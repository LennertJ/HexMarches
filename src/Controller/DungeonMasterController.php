<?php

namespace App\Controller;

use App\Entity\DungeonMaster;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DungeonMasterController extends AbstractController
{
    /**
     * @Route("/dungeon/master", name="dungeon_master")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DungeonMasterController.php',
        ]);
    }

    /**
     * @Route("dm/new_dm", name="new_Dm",methods={"POST","HEAD"})
     * @param Request $request
     * @return Response
     */
    public function newDm(Request $request )
    {
        $entityManager = $this->getDoctrine()->getManager();

        $dmName= $request->request->get('name');
        $dmId = $request->request->get('dmId');
        $dm = new DungeonMaster();
        $dm->setDungeonMasterName($dmName);
        $dm->setDungeonMasterId($dmId);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($dm);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new dm with id '.$dm->getDungeonMasterId());
    }

    /**
     * @Route("dm/getdms", name="get_all_dms",methods={"GET","HEAD"})
     * @return Response
     */
    public function GetAllDms(){
        $entityManager = $this->getDoctrine()->getManager();

        $response=[];
        $dmArray = $entityManager->getRepository(DungeonMaster::class)->findAll();
        for($i=0; $i<sizeof($dmArray); $i++){
            $response[$i] = $dmArray[$i]->jsonSerialize();
        }

        return new JsonResponse( $response);
    }
}
