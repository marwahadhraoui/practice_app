<?php

namespace App\Tests\Entity;

use App\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApplicationTest extends KernelTestCase
{

    public function getEntity(): Application
    {
        return (new Application)
            ->setName('Name of Application')
            ->setUrl('https://www.facebook.com');
    }

    public function assertHasErrors(Application $application, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($application);
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

        $this->assertHasErrors($this->getEntity()->setName('application12'), 1);
        $this->assertHasErrors($this->getEntity()->setUrl('a.exemple.com'), 1);
    }

    public function testInvalidBlankattribute()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
        $this->assertHasErrors($this->getEntity()->setUrl(''), 1);
    }
}
