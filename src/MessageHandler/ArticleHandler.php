<?php

namespace App\MessageHandler;

use App\Entity\Article;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ArticleHandler implements MessageHandlerInterface
    {
    public function __invoke(Article $message)
        {
        echo 'Your file is being created';
        $fileName = 'article_' . $message->getId() . '.txt';
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile('C:\wamp64\www\practice_app\App\GeneratedFiles/' . $fileName, 'Title: ' . $message->getTitle() . PHP_EOL . 'Content: ' . $message->getContent() . PHP_EOL . 'Image: ' . $message->getImage());
        }
    }