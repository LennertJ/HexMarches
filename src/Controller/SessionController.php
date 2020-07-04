<?php

namespace App\Controller;

use App\Entity\CharacterRequestSession;
use App\Entity\DungeonMaster;
use App\Entity\Player;
use App\Entity\Session;
use App\Entity\SessionRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="session")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SessionController.php',
        ]);
    }

    /**
     * @Route("session/newPlannedSession", name="new_PlannedSession",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function newPlannedSession(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $playingDm = $request->request->get('dmId');
        $sessionNumber = $request->request->get("sessionNumber");
        $sessionStatus = $request->request->get("sessionStatus");
        $sessionRequestId = $request->request->get("sessionRequestId");

        $sessionRequest = $entityManager->getRepository(SessionRequest::class)->findOneBy(array('RequestId'=>$sessionRequestId));

        if(!$sessionRequest){
            throw $this->createNotFoundException(
                'No session Request found with that id: '. $sessionRequestId
            );
        }

        $session = new Session();
        $session->setObjective($sessionRequest->getObjective());
        $session->setDate($sessionRequest->getDate());
        $session->setDungeonMasterId($playingDm);
        $session->setSessionNumber($sessionNumber);
        $session->setSessionStatus($sessionStatus);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($session);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Dm Added to session, dm id = '.$session->getDungeonMasterId());
    }

    /**
     * @Route("session/getSession/{sessionId}", name="get_session",methods={"GET","HEAD"})
     * @param $sessionId
     * @return string
     */
    public function GetSession($sessionId){
        $entityManager = $this->getDoctrine()->getManager();

        $session = $entityManager->getRepository(Session::class)->findOneBy(array('RequestId'=>$sessionId));
        $participatingPlayers = $entityManager->getRepository(CharacterRequestSession::class)->findBy(array('RequestId'=>$sessionId));
        $dm = $entityManager->getRepository(DungeonMaster::class)->findOneBy(array('DungeonMasterId'=>$session->getDungeonMasterId()));
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
        if(!$dm){
            throw $this->createNotFoundException(
                'This session contains no active dungeon master sessionId: '.$sessionId
            );
        }
        $response[0] = $session->jsonSerialize();
        $response[1] = $dm->jsonSerialize();

        for($i=0; $i< sizeof($participatingPlayers); $i++){
            $response[$i+2] = $entityManager->getRepository(Player::class)
                ->findOneBy(array('PlayerId'=>$participatingPlayers[$i]->getCharacterId()))
                ->jsonSerialize();
        }
        return new JsonResponse( $response);
    }
}
