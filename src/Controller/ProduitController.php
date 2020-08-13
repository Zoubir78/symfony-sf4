<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * On définit un préfixe pour les URIs et noms de route de ce controller
 * @Route("/produit", name="produit_")
 */

class ProduitController extends AbstractController
{
    /**
     * Liste des produits
     *       URI: /produit/
     *       nom: produit_list
     * @Route("/", name="list")
     */
    public function index(ProduitRepository $repository)
    {
        return $this->render('produit/index.html.twig', [
            'liste_produits' => $repository->findAll(),
        ]);
    }

    // /**
    //  * page d'ajour de produits
    //  * @Rroute("/ajout", name="ajout")
    //  */
    // public function ajout()
    // {
    //     return $this->render('produit/ajout.html.twig');
    // }
}
