<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture" , name="list_voiture")
     */
    public function listVoiture():Response{
        $em=$this->getDoctrine()->getManager();
        $voitures= $em->getRepository("App\Entity\Voiture")->findAll();
        return $this->render('voiture/listeVoiture.html.twig',["listVoiture"=>$voitures]);
    }

    /**
     * @Route ("/addVoiture" , name="Ajout_voiture")
     */
    public function addVoiture(Request $request): Response{
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('list_voiture');

        }
        return $this->render('voiture/addVoiture.html.twig' , ["formVoiture"=>$form->createView()]);
    }
    /**
     * @Route("/deleteVoiture/{id}" , name="voitureDelete")
     */
    public function deleteVoiture($id):Response{

        $em=$this->getDoctrine()->getManager();
        $voiture=$em->getRepository("App\Entity\Voiture")->find($id);

        if ($voiture !== null){
            $em->remove($voiture);
            $em->flush();
        }
        else{
            throw new NotFoundHttpException("la voiture d'id ".$id."n'existe pas !!!");

        }
        return $this->redirectToRoute('list_voiture');
    }

    /**
     * @Route ("/updateVoiture/{id}" , name="voitureUpdate")
     */
    public function updateVoiture(Request $request , $id):Response{
        $em=$this->getDoctrine()->getManager();
        $voiture=$em->getRepository("App\Entity\Voiture")->find($id);

        $editform= $this->createForm(voitureType::class , $voiture);
        $editform->handleRequest($request);
        if($editform->isSubmitted() and $editform->isValid()){
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute('list_voiture');
        }
        return $this->render('voiture/updateVoiture.html.twig',['editFormVoiture'=>$editform->createView()]);
    }

    /**
     * @Route("/searchVoiture" , name="voitureSearch")
     */

    public function searchVoiture(Request $request ):Response
    {
        $em = $this->getDoctrine()->getManager();
        $voitures = null;

        if($request->isMethod('POST')){
            $serie = $request->get("input-serie");
            $query =   $em->createQuery(
                "SELECT v FROM App\Entity\Voiture v where v.serie LIKE ' ".$serie."'");
            $voitures = $query->getResult();
    }
        return $this->render("voiture/rechercheVoiture.html.twig",
         ["voitures"=>$voitures] );
    }
}