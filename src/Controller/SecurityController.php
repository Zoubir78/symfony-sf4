<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        
        // 2) Passer la requête HTTP au formulaire (recupèrer les données envoyées)
        $form->handleRequest($request);

        // 3) Vérifier que le formulaire ait été envoyé et est valide
        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            // 4) Récupèrer les données du formulaire
            $user = $form->getData();
            // dd($user);
            
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Vous venez de vous inscrire sur notre site !');
            return $this->redirectToRoute('security_login');
            
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */

    public function login()
    {
        // $this->addFlash('success', 'Vous êtes bien connecté !');
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */

    public function logout()
    {
        $this->addFlash('success', 'Vous êtes bien déconnecté !');
        return $this->render('security/login.html.twig');
    }
}