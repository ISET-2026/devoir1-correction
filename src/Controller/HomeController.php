<?php

namespace App\Controller;

use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ProjetRepository $projetRepository,
        EnseignantRepository $enseignantRepository,
        EtudiantRepository $etudiantRepository,
    ): Response {
        $countByStatut = $projetRepository->countByStatut();
        $totalProjets = array_sum($countByStatut);

        return $this->render('home/index.html.twig', [
            'totalProjets' => $totalProjets,
            'totalEnseignants' => $enseignantRepository->count([]),
            'totalEtudiants' => $etudiantRepository->count([]),
            'countByStatut' => $countByStatut,
            'derniersProjets' => $projetRepository->findBy([], ['dateDebut' => 'DESC'], 5),
        ]);
    }
}
