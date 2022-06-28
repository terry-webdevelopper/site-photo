<?php

namespace App\Controller\Admin;

use App\Entity\Photos;
use App\Entity\User;
use App\Form\PhotoType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(UserRepository $userrepo): Response
    {
        return $this->render('admin/index_admin.html.twig', [
            'listeUser' => $userrepo->findAll(),
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/send_photo/{id}', name: 'send_photo')]
    public function send_photo(User $user, Request $request): Response
    { 
        if (!$user || !$this->isGranted('ROLE_ADMIN', $user->getRoles())) return $this->redirectToRoute('accueil');

        $formPhoto = $this->createForm(PhotoType::class);
        $formPhoto->handleRequest($request);

        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            
            for ($i=0; $i < count($formPhoto->get('name')->getData()) ; $i++) { 
                $photo = new Photos();

                $image = $formPhoto->get('name')->getData()[$i];
                $nomOriginal = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $nomUnique = $nomOriginal . "-" . time() . "." . $image->guessExtension();
                $image->move('assets/uploads/img', $nomUnique);
                $photo->setAime(0);


                $photo->setName($nomUnique);
                $photo->setUser($user);
                $manager->persist($photo);
            
            }
            $manager->flush();     

            return $this->redirectToRoute("profil", ["id"=>$user->getId()]);
            
        }
      
            return $this->render('admin/ajout.html.twig', [
                'formPhoto'=>$formPhoto->createView()
            ]);
        
    }

    #[Route('/delete/{id}', name: 'delete')]
    // on recupere l'objet photo avec l'id choisi
    public function delete(Photos $photo): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($photo);
        $manager->flush();
        

        return new Response(json_encode($photo));
    }
}


