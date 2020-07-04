<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\CharacterRequestSession;
use App\Entity\DungeonMaster;
use App\Entity\Player;
use App\Entity\SessionRequest;
use DateTime;
use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;

class SessionRequestController extends AbstractController
{
    /**
     * @Route("/session/request", name="session_request")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SessionRequestController.php',
        ]);
    }

    /**
     * @Route("sessionRequest/newRequest", name="new_sessionRequest",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function newSessionRequest(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $request_id = $request->request->get('messageId');
        $date = $request->request->get('date');
        $objective = $request->request->get('objective');
        $players = $request->request->get('playerIdArray');

        $players = preg_split("/[\s,]+/",$players);

        $sessionRequest = new SessionRequest();
        $sessionRequest->setDate($date);
        $sessionRequest->setObjective($objective);
        $sessionRequest->setRequestId($request_id);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($sessionRequest);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $sessionId = $sessionRequest->getRequestId();
        for($i=0 ; $i< sizeof($players); $i++){
            $playerEntity = $entityManager->getRepository(Player::class)->findOneBy(array('PlayerId'=>"".$players[$i]));
            $characterRequestSession = new CharacterRequestSession();
            $characterRequestSession->setCharacterId($playerEntity->getPlayerId());
            $characterRequestSession->setRequestId($sessionId);
            $entityManager->persist($characterRequestSession);
        }
        $entityManager->flush();

        return new Response('Saved new session request with id '.$sessionRequest->getId());
    }

    /**
     * @Route("sessionRequest/getSession/{sessionId}", name="get_session",methods={"GET","HEAD"})
     * @param $sessionId
     * @return string
     */
    public function GetSession($sessionId){
        $entityManager = $this->getDoctrine()->getManager();

        $session = $entityManager->getRepository(SessionRequest::class)->findOneBy(array('RequestId'=>$sessionId));
        $participatingPlayers = $entityManager->getRepository(CharacterRequestSession::class)->findBy(array('RequestId'=>$sessionId));
        if(!$session) {
            throw $this->createNotFoundException(
                'No session found with that id: ' . $sessionId
            );
        }
        if(!$participatingPlayers){
            throw $this->createNotFoundException(
                'This session contains no active players sessionId: '.$sessionId
            );
        }
        $response[0] = $session->jsonSerialize();

        for($i=0; $i< sizeof($participatingPlayers); $i++){
            $response[$i+1] = $entityManager->getRepository(Player::class)
                    ->findOneBy(array('PlayerId'=>$participatingPlayers[$i]->getCharacterId()))
                    ->jsonSerialize();
        }
        return new JsonResponse( $response);
    }

    /**
     * @Route("sessionRequest/addPlayer", name="add_player_to_sessionRequest",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function AddPlayerToRequest(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $request_id = $request->request->get('messageId');
        $editorId = $request->request->get('editorId');
        $players = $request->request->get('playerIdArray');

        $players = preg_split("/[\s,]+/",$players);

        $playerObjects = $entityManager->getRepository(CharacterRequestSession::class)->findBy(array('RequestId'=>$request_id));
        $owner = $entityManager->getRepository(Player::class)->findOneBy(array('PlayerId'=>$playerObjects[0]->getCharacterId()));
        $dmArray = $entityManager->getRepository(DungeonMaster::class)->findAll();

        if($editorId != $owner->getPlayerId()){
            $editedByDm=false;
            for($i=0; $i< sizeof($dmArray); $i++){
                if($dmArray[$i]->getDungeonMasterId() == $editorId ){
                    $editedByDm=true;
                }
            }
            if(!$editedByDm){
                return new Response(
                    "only owner or dm can add players to session",401
                );
            }
        }

        for($i=0 ; $i< sizeof($playerObjects); $i++){
            for($j=0; $j<sizeof($players);$j++){
                if($playerObjects[$i]->getCharacterId()==$players[$j]){
                    return new Response(
                        "player is allready in that session",409
                    );
                }
            }
        }

        $sessionId = $request_id;
        for($i=0 ; $i< sizeof($players); $i++){

            $playerEntity = $entityManager->getRepository(Player::class)->findOneBy(array('PlayerId'=>"".$players[$i]));
            $characterRequestSession = new CharacterRequestSession();
            $characterRequestSession->setCharacterId($playerEntity->getPlayerId());
            $characterRequestSession->setRequestId($sessionId);
            $entityManager->persist($characterRequestSession);
        }
        $entityManager->flush();

        return new Response('Added Players to session session request with id '. $request_id);
    }

}
