<?php

namespace App\Controller;

use App\Entity\Etudiant;
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
    public function index(EtudiantRepository $repository): Response
    {
        $value = $repository->findAll();
        return $this->render(
            'etudiant/listEtudiant.html.twig',
            array("tabEtudiant" => $value)
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
