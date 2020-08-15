<?php

namespace App\Controller;

use App\Entity\Produit;
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

    /**
     * Modification d'un produit
     * @Route("/{id}", name="modif")
     * le composant ParamConverter va convertir le paramètre id en l'entité associée
     */
    public function modification(Produit $produit, Request $request, EntityManagerInterface $entityManager)
    {
        // On passe l'entité à modifier en 2ème argument (arg. "data")
        // Pour que l'objet soit directement modifier et pour pré-remplir le formulaire
        $form = $this->createForm(ProduitFormType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Il n'est pas nécessaire de récupèrer les données du formulaire: l'entité a été modifiée par celui-ci
            // On appelle pas non plus $entityManager->persist() car Doctrine connait déjà l'existance de l'entité 
            $entityManager->flush();
            $this->addFlash('success', 'Le produit a été mis à jour.');
            return $this->redirectToRoute('produit_list');
        }

        return $this->render('produit/modif.html.twig', [
            'produit' => $produit,
            'produit_form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'un produit
     * @Route("/{id}/supprimer", name="supprimer")
     */
    public function supprimer(Produit $produit, EntityManagerInterface $entityManager)
    {
        // Suppression
        $entityManager->remove($produit);
        $entityManager->flush();

        // Message & redirection
        $this->addFlash('info', 'Le produit a été supprimé.');
        return $this->redirectToRoute('produit_list');
    }
}
