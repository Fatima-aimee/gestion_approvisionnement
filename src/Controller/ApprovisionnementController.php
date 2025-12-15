<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ApprovisionnementRepository;

final class ApprovisionnementController extends AbstractController
{
        private const LIMIT_PAR_PAGE=5;
    #[Route('/approvisionnement', name: 'approvisionnement_index')]
    public function list(ApprovisionnementRepository $repo, Request $request): Response
    {
        $approvisionnements = $repo->findAll();
        $fournisseurs = $repo->findFournisseurs();
        $totalMontant = $repo->findTotalMontant();
        $page=$request->query->get("page",1);
        $size=$request->query->get("size",self::LIMIT_PAR_PAGE);
        $offset=($page-1)*$size;
        //Entites
         $approvisionnements=$repo->findBy([],[
            "id"=>"desc"
         ],$size, $offset);
        $count =$repo->count([]);
        $nbrePage=  ceil($count /$size);
        return $this->render('approvisionnement/index.html.twig', [
            'approvisionnements' => $approvisionnements,
            'fournisseurs' => $fournisseurs,
            'totalMontant' => $totalMontant,
            'periode' => 'Avril 2023',
            'fournisseurPrincipal' => [
                'nom' => 'Textiles Dakar',
                'montant' => 1430000,
                'pourcentage' => 52.5
            ],
    
            "nbrePage"=>$nbrePage,
            "pageEncours"=>$page,
        ]);

    }

    #[Route('/approvisionnement/{id}', name: 'approvisionnement_show')]
    public function show(ApprovisionnementRepository $repo, int $id): Response
    {
        $approvisionnement = $repo->find($id); 
        if (!$approvisionnement) {
            throw $this->createNotFoundException('Approvisionnement non trouvé');
        }
        return $this->render('approvisionnement/show.html.twig', [
            'approvisionnement' => $approvisionnement
        ]);
    }

    #[Route('/approvisionnement/new', name: 'approvisionnement_new')]
    public function new(): Response
    {
        // Logique pour créer un nouvel approvisionnement (formulaire, validation, etc.)
        return $this->render('approvisionnement/new.html.twig');
    }


}
