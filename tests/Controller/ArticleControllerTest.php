<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
    {
    public function testindex(): void
        {
        $client = static::createClient();
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Test Title Article');
        }

    public function testNew()
        {
        $client = static::createClient();
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/new');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create new Article');
        // récuperer le formulaire
        $submitButton = $crawler->selectButton('Save');
        $form = $submitButton->form();
        $form['article[title]'] = 'Article title';
        $form['article[content]'] = 'Article content';
        $form['article[image]'] = 'image.png';
        // soumettre le formulaire
        $client->submit($form);
        // la redirection
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/');
        $this->assertResponseIsSuccessful();
        }

    public function testedit()
        {
        $client = static::createClient();
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/5/edit');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Edit Article');
        // récuperer le formulaire
        $submitButton = $crawler->selectButton('Update');
        $form = $submitButton->form();
        $form['article[title]'] = 'Article title';
        $form['article[content]'] = 'Article content';
        $form['article[image]'] = 'image.png';
        // soumettre le formulaire
        $client->submit($form);
        // la redirection
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/');
        $this->assertResponseIsSuccessful();
        }

    public function testdelete()
        {
        $client = static::createClient();
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/23/edit');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Edit Article');
        // récuperer le formulaire
        $submitButton = $crawler->selectButton('Delete');
        $form = $submitButton->form();
        // soumettre le formulaire
        $client->submit($form);
        // la redirection
        $crawler = $client->request('GET', 'https://127.0.0.1:8000/article/');
        $this->assertResponseIsSuccessful();
        }
    }