<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * TODO: Upload image
             * 1 - Récupérer l'image (dans une variable avec request)
             * 2 - Modifier le nom de l'image (nom unique)
             * 3 - Enregistrer l'image dans son répertoire ('articles_images')
             * 4 - Enregistrer le nom de l'image en BDD (setImage)
             */
             

            // 1 - Récupérer l'image (dans une variable avec request)
            $image = $form->get('image')->getData();

                    // Si une image a été uploadée
                if ($image) {
                      //2 - Modifier le nom de l'image (nom unique)
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // Transforme le nom de l'image en slug pour l'URL (minuscule, sans accent, sans espace, etc.)
                $safeFilename = $slugger->slug($originalFilename);
                 // Reconstruit le nom de l'image avec un identifiant unique et son extension
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
    
                    // * 3 - Enregistrer l'image dans son répertoire ('articles_images')
                    try {
                        $image->move(
                            $this->getParameter('articles_images'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                    }
    
                    // 4 - Ajouter le nom de l'image à l'objet(setImage)
                    $article->setImage($newFilename);
                }
            
                  
                

            



            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
