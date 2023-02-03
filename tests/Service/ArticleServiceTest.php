<?php

namespace App\Tests\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleServiceTest extends WebTestCase
{
    public function getEntity(): Article
    {
        return (new Article())
            ->setTitle('Article Title')
            ->setContent('Article content')
            ->setImage('image.png')
            ->setCreatedAt(new \DateTime());
    }

    public function testValidateAddingArticleTrue()
    {
        $article = $this->getEntity();
        $articleRepository = $this->createMock(ArticleRepository::class);
        $articleRepository->method('find')->willReturn($article);
        $articleService = new ArticleService();
        $newArticle = $articleService->validateAddingArticle($article, $articleRepository);
       
        $this->assertTrue($newArticle);
    }

    public function testValidateAddingArticleFalse()
    {
        $article = $this->getEntity();
        $articleRepository = $this->createMock(ArticleRepository::class);
        $articleRepository->method('find')->willReturn(null);
        $articleService = new ArticleService();
        $result = $articleService->validateAddingArticle($article, $articleRepository);
        $this->assertFalse($result);
    }
}
