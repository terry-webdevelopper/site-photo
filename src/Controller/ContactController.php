<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    // on appelle la méthode MailerInterface que l'on va appeller avec la variable $mailer 
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        // gestion du formulaire
        if($form->isSubmitted() && $form->isValid()){
            // le traitement
            // on recupère les données
            $contact = $form->getData();
            // prépare ou construit un email: qui l'envoie, qui le reçoit etc
            $message = (new TemplatedEmail())
            ->subject('Nouveau Contact')
            // on attend l'expéditeur,
            ->from($contact['email'])
            // on attribue le destinataire
            ->to('bterrybenjamin@yahoo.fr')
            // on crée le message avec la vue twig
            ->htmlTemplate('emails/contact.html.twig')
            ->context(['contact'=>$contact]);
            // on envoie le message
            $mailer->send($message);
            // on confirme et on redirige
            $this->addFlash('message', 'Le message a bien été envoyé');
            return $this->redirectToRoute('accueil');
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
