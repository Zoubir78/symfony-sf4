<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="security_contact")
     */
    public function registration(Request $request, EntityManagerInterface $manager)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        
        // 2) Passer la requête HTTP au formulaire (recupèrer les données envoyées)
        $form->handleRequest($request);

        // 3) Vérifier que le formulaire ait été envoyé et est valide
        if($form->isSubmitted() && $form->isValid()){

            // 4) Récupèrer les données du formulaire
            $contact = $form->getData();
            // dd($contact);
            
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre message a été envoyé !');
            return $this->redirectToRoute('security_contact');

        }

        return $this->render('security/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
