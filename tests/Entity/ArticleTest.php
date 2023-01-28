<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArtcileTest extends KernelTestCase
{
    public function getEntity(): Article
    {
        return (new Article())
            ->setTitle('Article Title')
            ->setContent('Article content')
            ->setImage('image.png')
            ->setCreatedAt(new \DateTime());
    }
    public function assertHasErrors(Article $article, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($article);
        $messages = [];
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . '=> ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }
    public function testValidEntity()
    {

        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEntity()
    {

        $this->assertHasErrors($this->getEntity()->setTitle('Article123Title'), 1);
    }

    public function testInvalidBlankattribute()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(''), 1);
        $this->assertHasErrors($this->getEntity()->setContent(''), 1);
    }
}
