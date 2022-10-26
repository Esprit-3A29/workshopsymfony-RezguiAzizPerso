<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\StudentRechType;
use App\Form\StudentType;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/Etudiant', name: 'app_etudiant')]
    public function index(Request $request, EtudiantRepository $repository): Response
    {
        $value = $repository->findAll();
        $sortbymoy = $repository->sortbymoy();
        $formRech = $this->createForm(StudentRechType::class);
        $formRech->handleRequest($request);
        if ($formRech->isSubmitted()) {
            $nce = $formRech->get('nce')->getData();
            $result = $repository->searchStudent($nce);
            return $this->renderForm(
                "etudiant/listEtudiant.html.twig",
                array("tabEtudiant" => $result, "formRech" => $formRech, "sortbymoy" => $sortbymoy,)
            );
        }
        return $this->renderForm(
            'etudiant/listEtudiant.html.twig',
            array("tabEtudiant" => $value, "sortbymoy" => $sortbymoy, "formRech" => $formRech)
        );
    }
    #[Route('/AddEtudiant', name: 'Add_etudiant')]
    public function AddEtud(EtudiantRepository $repository, ManagerRegistry $doctrine, Request $request)
    {
        $student = new Etudiant();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $repository->add($student, true);
            return  $this->redirectToRoute("app_etudiant");
        }
        return $this->renderForm("etudiant/AddEtudiant.html.twig", array("formEtudiant" => $form));
    }
}
