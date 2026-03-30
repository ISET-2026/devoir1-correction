<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'app_projet_index', methods: ['GET'])]
    public function index(Request $request, ProjetRepository $projetRepository): Response
    {
        $search = $request->query->get('search');
        $statut = $request->query->get('statut');
        $sort = $request->query->get('sort', 'dateDebut');
        $order = $request->query->get('order', 'DESC');
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 5;

        $paginator = $projetRepository->findBySearchAndFilter($search, $statut, $sort, $order, $page, $limit);
        $totalItems = count($paginator);
        $totalPages = (int) ceil($totalItems / $limit);

        return $this->render('projet/index.html.twig', [
            'projets' => $paginator,
            'search' => $search,
            'statut' => $statut,
            'sort' => $sort,
            'order' => $order,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'statuts' => [
                Projet::STATUT_EN_PREPARATION,
                Projet::STATUT_EN_COURS,
                Projet::STATUT_TERMINE,
            ],
        ]);
    }

    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            $this->addFlash('success', 'Le projet "' . $projet->getTitre() . '" a été créé avec succès !');
            return $this->redirectToRoute('app_projet_index');
        }

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le projet "' . $projet->getTitre() . '" a été modifié avec succès !');
            return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
        }

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->getPayload()->get('_token'))) {
            $titre = $projet->getTitre();
            $entityManager->remove($projet);
            $entityManager->flush();

            $this->addFlash('danger', 'Le projet "' . $titre . '" a été supprimé.');
        }

        return $this->redirectToRoute('app_projet_index');
    }
}
