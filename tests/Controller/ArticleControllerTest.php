<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleControllerTest extends WebTestCase
{
    // public function testindex():void{

    //     // $client = static::createClient();
    //     // $urlGenerator = $client->getContainer()->get('router');
    //     // $client->request(Request::METHOD_GET, $urlGenerator->generate('app_article_index'));
    //     // $this->assertResponseIsSuccessful();
    //     // $this->assertRouteSame('app_article_index');
    //}

    public function testNew()
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_article_new'));
        //récuperer le formulaire 
        $submitButton = $crawler->selectButton('Save');
        $form = $submitButton->form();
        $form["article[title]"] = "Article title";
        $form["article[content]"] = "Article content";
        $form["article[image]"] = "image.png";
        //soumettre le formulaire
        $client->submit($form);
        //gérer la redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        //gérer la route
        $this->assertRouteSame('app_article_index');
    }
}
