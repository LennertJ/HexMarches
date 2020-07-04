<?php

namespace App\Controller;

use App\Entity\Character;
//use http\Env\Request;
//use http\Env\Response;
use App\Repository\PlayerRepository;
use ContainerXGR1jx0\getCharacterRepositoryService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CharacterRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use function MongoDB\BSON\toJSON;

class CharacterController extends AbstractController
{

    /**
     * @Route("/character", name="character")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    /**
     * @Route("character/newCharacter", name="new_character",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function newCharacter(Request $request )
    {
        $entityManager = $this->getDoctrine()->getManager();

        $url = $request->request->get('picture');
        $class = $request->request->get('class');
        $description = $request->request->get('description');
        $level = $request->request->get('level');
        $race = $request->request->get('race');
        $playerId = $request->request->get('playerId');
        $name = $request->request->get('name');

        $character = new Character($playerId);
        $character->setClass($class);
        $character->setDescription($description);
        $character->setLevel($level);
        $character->setRace($race);
        $character->setPlayerId($playerId);
        $character->setName($name);
        $character->setPictureUrl($url);
        $character->setCharacterId(0);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($character);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new character with id '.$character->getId()." created by: ".$character->getPlayerId());
    }

    /**
     * @Route("character/updateCharacter/{characterName}/{userId}", name="update_character",methods={"POST","HEAD"})
     * @param Request $request
     * @param $characterName
     * @param $userId
     * @return Response
     */
    public function UpdateCharacter(Request $request , $characterName, $userId)
    {
        $this->validateName($characterName);
        $entityManager = $this->getDoctrine()->getManager();
        $character = $entityManager->getRepository(Character::class)->findOneBy(array('Name'=>$characterName));

        if(!$character){
            throw $this->createNotFoundException(
                'No character found with that name'.$characterName
            );
            return new Response("No existing character found",404);
        }else if($character->getPlayerId() != $userId){
            return new Response("trying to edit character that is not owned by this player",401);
        }
        $url = $request->request->get('picture');
        $class = $request->request->get('class');
        $description = $request->request->get('description');
        $level = $request->request->get('level');
        $race = $request->request->get('race');
        $name =  $request->request->get('name');

        $character->setClass($class);
        $character->setDescription($description);
        $character->setLevel($level);
        $character->setRace($race);
        $character->setName($name);
        $character->setPictureUrl($url);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($character);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('updated character with id '.$character->getId()." created by: ".$character->getPlayerId());
    }

    /**
     * @Route("character/getCharacter/{characterName}", name="get_character",methods={"GET","HEAD"})
     * @param $characterName
     * @return JsonResponse
     */
    public function GetCharacter(string $characterName){
        $this->validateName($characterName);
        $entityManager = $this->getDoctrine()->getManager();

        //$array = ["Name", $characterName];
        $character = $entityManager->getRepository(Character::class)->findOneBy(array('Name'=>$characterName));
        if(!$character) {
            throw $this->createNotFoundException(
                'No character found with that name: ' . $characterName
            );
        }
        return new JsonResponse( $character->jsonSerialize());
    }

    /**
     * @Route("character/updateCharacter/{characterName}/{userId}", name="update_character",methods={"POST","HEAD"})
     * @param $characterName
     * @param $userId
     * @return Response
     */
    public function DeleteCharacter(string $characterName, $userId){
        $this->validateName($characterName);
        $entityManager = $this->getDoctrine()->getManager();
        $character = $entityManager->getRepository(Character::class)->findOneBy(array('Name'=>$characterName));

        if(!$character){
            throw $this->createNotFoundException(
                'No character found with that name '. $characterName
            );
        }else if($character->getPlayerId() != $userId){
            return new Response("trying to edit character that is not owned by this player",401);
        }

        $entityManager->remove($character);
        $entityManager->flush();
        return new Response("character with name " . $characterName . " deleted" , 200 );
    }

    public function validateName($name){
        if (!(is_string($name))) {
            throw new \InvalidArgumentException("Moet een string zijn!");
        }
    }
}
