<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
    {
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    
    public function index(ArticleService $articleService, ArticleRepository $articleRepository, Request $request): Response
        {
           
            
        $paginator = $articleService->Paginate($request, $articleRepository);

        return $this->render('article/index.html.twig', [
            'articles' => $paginator['articles'],
            'page' => $paginator['page'],
            'limit' => $paginator['limit'],
            'total' => $paginator['total'],
        ]);
        }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new (Request $request, ArticleRepository $articleRepository, ArticleService $articleService, MessageBusInterface $bus): Response
        {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime());
            $articleService->saveArticle($article, true, $articleRepository);
            $newArticle = $articleService->validateAddingArticle($article, $articleRepository);
            if ($newArticle) {
                $bus->dispatch($article);

                return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
                }
            }

        return $this->renderForm('article/new.html.twig', [
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
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository, ArticleService $articleService): Response
        {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleService->saveArticle($article, true, $articleRepository);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
            }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
        }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository, ArticleService $articleService): Response
        {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $articleService->deleteArticle($article, true, $articleRepository);
            }
        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }
    }