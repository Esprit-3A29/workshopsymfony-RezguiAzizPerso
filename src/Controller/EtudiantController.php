<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
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
            array("tabclub" => $value)
        );
    }
}
