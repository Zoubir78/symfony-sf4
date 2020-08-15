<?php

namespace App\Controller;

use App\Form\ProduitFormType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * page d'ajour de produits
     * @Route("/ajout", name="ajout")
     */
    public function ajout(Request $request, EntityManagerInterface $entityManager)
    {
        // 1) Création du formulaire
        $form = $this->createForm(ProduitFormType::class);

        // 2) Passer la requête HTTP au formulaire (recupèrer les données envoyées)
        $form->handleRequest($request);

        // 3) Vérifier que le formulaire ait été envoyé et est valide
        if($form->isSubmitted() && $form->isValid()){

            // 4) Récupèrer les données du formulaire
            $produit = $form->getData();
            // dd($produit);

            $entityManager->persist($produit);
            $entityManager->flush();

            //Message flash & redirection
            $this->addFlash('success', 'Le produit a été enregistré !');
            return $this->redirectToRoute('produit_list');
        }
        // 5) Pour afficher le formulaire, passer le résultat au formulaire
        return $this->render('produit/ajout.html.twig', [
            'produit_form' => $form->createView()
        ]);
    }
}
