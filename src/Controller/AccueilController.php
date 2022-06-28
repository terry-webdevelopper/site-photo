<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\User;
use App\Repository\PhotosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AccueilController extends AbstractController
{
    public $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/prestations', name: 'prestations')]
    public function prestation(): Response
    {
        return $this->render('prestations/prestations.html.twig');
    }

    #[Route('/tarifs', name: 'tarifs')]
    public function tarifs(): Response
    {
        return $this->render('tarifs/tarifs.html.twig');
    }

    #[Route('/portfolio', name: 'portfolio')]
    public function portfolio(): Response
    {
        return $this->render('portfolio/portfolio.html.twig');
    }

    #[Route('/apropos', name: 'apropos')]
    public function apropos(): Response
    {
        return $this->render('apropos/apropos.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('contact/contact.html.twig');
    }

    // on crée une route pour aller sur le profil d'un user
    // on récupere l'id de l'user
    #[Route('/profil/{id}', name: 'profil')]
    public function profil(User $user, PhotosRepository $photorepo): Response
    {

        // on verifie si id de celui qu'on recupere = l'id du user connecté
        if ($user->getId() == $this->security->getUser()->getId() || in_array('ROLE_ADMIN', $this->security->getUser()->getRoles())) {
            $photosByUser = $photorepo->findBy(['user'=>$user->getId()]);
            return $this->render('accueil/profil.html.twig',[
                'user'=> $user,
                'photosByUser' =>$photosByUser
            ]);
        }
        else {
            //si il n'est pas égale, on le redirige vers l'accueil
            return $this->redirectToRoute('accueil');
        }   
    }

    #[Route('/like/{id}', name: 'like')]
    // on recupere l'objet photo avec l'id choisi
    public function like(Photos $photos): Response
    {
        $manager = $this->getDoctrine()->getManager();
        
        if ($this->security->getUser()) {
            $photos->setAime(!$photos->getAime());
            $manager->persist($photos);
            $manager->flush();
        } 

        return new Response(json_encode($photos));
    }

}

