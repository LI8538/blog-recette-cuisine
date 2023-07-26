<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(ArticleRepository $articles): Response
    {
        return $this->render('home/home.html.twig', [
            'articles' => $articles->findAll(),
        ]);
    }
    

    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On stocke les données du formulaire dans des variables
            $nom =  $form->get('Nom')->getData();
            $prenom =  $form->get('Prenom')->getData();
            $sujet =  $form->get('Sujet')->getData();
            $email =  $form->get('Email')->getData();
            $tel = $form->get('Telephone')->getData();
            $message =  $form->get('Message')->getData();

            // On envoie l'email avec les données du formulaire
            $contactMessage = (new Email())
                ->from($email)
                ->to('hello@blogxpress.fr')
                ->subject('Vous avez reçu un nouveau message de ' . $nom . ' ' . $prenom)
                ->html("
                    <p>Vous avez reçu un nouveau message de la part de ' . $nom . ' ' . $prenom . 'au sujet de ' . $sujet.</p>
                    <p>Le message :</p>
                    <p>' . $message . '</p>
                    <p>Voici ses coordonnées :</p>
                    <ul>
                        <li>Email : ' . $email . '</li>
                        <li>Téléphone : ' . $tel . '</li>
                    </ul>
                ");

                $mailer->send($contactMessage);

                $this->addFlash('success', 'Votre message a bien été envoyé !');
                return $this->redirectToRoute('contact');

        }

        $result = $form->getData();
        
        return $this->render('home/contact.html.twig', [
            'contactForm' => $form,
            'result' => $result,
        ]);
    }

    #[Route('/article/{id}', name: 'article', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }

    

}
