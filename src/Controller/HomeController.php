<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{

    /**
     * page liste d'artistes
     * @Route("/list", name="list")
     */
    // public function list(Request $request)
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/HomeController.php',
    //         'get' => $request->query->get('test', 'défaut'), //si n y a rien il nous renvoie 'defaut'
    //         // 'get2' => $_GET['test'] ?? 'defaut',    // ==> ?? on remplace les else
    //     ]);
    // }
     /**
     * page connexion
     * @Route("/connexion", name="connexion")
     */
    // public function connexion(Request $request, Session $session)
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/HomeController.php',
    //         'get' => $request->query->get('test', 'défaut'), //si n y a rien il nous renvoie 'defaut'
    //         // 'get2' => $_GET['test'] ?? 'defaut',    // ==> ?? on remplace les else
    //         'session' => get_class($session), 
    //         'session' => $session->has('cle_inexistante'),
    //     ]);
    // }

    /**
     * page d'accueil
     * @Route("/", name="homepage")
     */

    public function home(ProduitRepository $repository)
    {
        // Action                                       méthode         si résultats    si aucun résultat
        // Récupérer toutes les entités                 findAll()       array           array (vide)
        // Récupérer des entités selon des critères     findBy()        array           array (vide)
        // Récupérer 1 entité selon des critères        findOneBy()     object          null
        // Récupérer 1 entité selon son ID              find()          object          null
        $resultat = $repository->findAll();
        dd($resultat);

        //Afficher le template Twig home.html.twig
        return $this->render('home.html.twig', [
            'foo' => 'bar',
            'booleen' => true,
            'produits' => ['Jean', 'Pull', 'Bonnet']
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(EntityManagerInterface $em)
    {
        //Création d'une entité Produit
        $produit = new Produit();
        dump($produit);

        //Enchainement de méthodes (method-chaining): l'objet se retourne lui-meme à chaque setter

        $produit
            ->setNom('Jeans')
            ->setDescription('un super jean très résistant !!')
            ->setPrix('55.00')
            ->setQuantite(30)
        ;
        dump($produit); 

        //Insertion en base
        $em->persist($produit); //On prépare l'insertion
        $em->flush();           //On enregistre en base
        dump($produit); 

        //Modification

        $produit->setDescription('');
        $em->flush();         
        dump($produit); 

        //Suppression

        $em->remove($produit);  // On prépare à la suppression
        $em->flush();         
        dd($produit);
    }

    // /**
    //  * @Route("/{id}", name="home")  //URI
    //  */
    // public function index($id, Request $request, Session $session)
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/HomeController.php',
    //         'id' => $id,
    //         'get' => $request->query->get('test', 'défaut'), //si n y a rien il nous renvoie 'defaut'
    //         // 'get2' => $_GET['test'] ?? 'defaut',    // ==> ?? on remplace les else
    //         'session' => get_class($session), 
    //         'session' => $session->has('cle_inexistante'),
    //     ]);
    // }
}
