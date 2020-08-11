<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{

    /**
     * page d'accueil
     * @Route("/", name="homepage")
     */

    public function home()
    {
        //Afficher le template Twig home.html.twig
        return $this->render('home.html.twig', [
            'foo' => 'bar',
            'booleen' => true,
            'produits' => ['Jean', 'Pull', 'Bonnet']
        ]);
    }

    /**
     * @Route("/{id}", name="home")  //URI
     */
    public function index($id, Request $request, Session $session)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
            'id' => $id,
            'get' => $request->query->get('test', 'défaut'), //si n y a rien il nous renvoie 'defaut'
            // 'get2' => $_GET['test'] ?? 'defaut',    // ==> ?? on remplace les else
            'session' => get_class($session), 
            'session' => $session->has('cle_inexistante'),
        ]);
    }
}
