<?php

namespace App\Controller;

use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player", name="player")
     */
    public function index()
    {
        return $this->json([
            'PlayerId' => 723864742367723593,
            'PlayerName' => 'Micro-Ice',
        ]);
    }

    /**
     * @Route("/player/newPlayer", name="new_Player",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function newPlayer(Request $request )
    {
        $entityManager = $this->getDoctrine()->getManager();

        $playerName= $request->request->get('name');
        $playerId = $request->request->get('playerId');
        $player = new Player();
        $player->setPlayerName($playerName);
        $player->setPlayerId($playerId);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new player with id '.$player->getPlayerId());
    }

    /**
     * @Route("/player/updatePlayer", name="new_Player",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function updatePlayer(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $playerName= $request->request->get('name');
        $playerId = $request->request->get('playerId');
        $player = $entityManager->getRepository(Player::class)->findOneBy(array('PlayerId'=>$playerId));

        if(!$player) {
            throw $this->createNotFoundException(
                'No player created yet for this discordId' . $playerId
            );
        }

        $player->setPlayerName();
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($player);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();


        return new Response("succesfully Updated",200);
    }
}
