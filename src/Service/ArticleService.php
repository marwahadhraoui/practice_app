<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;

class ArticleService
{
    public function getAllArticles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $articles;
    }

    public function Paginate(Request $request, ArticleRepository $articleRepository)
    {
        //  we define the number of elements per page
        $limit = 3;
        //  we get the page number
        $page = (int) $request->query->get('page', 1);
        //  we get the articles of the page
        $articles = $articleRepository->getPaginatedArticle($page, $limit);
        //  we get the total number of articles
        $total = count($articleRepository->findAll());

        return ['page' => $page, 'limit' => $limit, 'total' => $total, 'articles' => $articles];
    }
}
