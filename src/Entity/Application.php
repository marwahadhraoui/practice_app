<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Asserts;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
    {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Asserts\NotBlank()]
    #[Asserts\Regex(
    pattern: '/\d/', match
    : false,
    message: 'Name of the application cannot contain a number',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Asserts\Url()]
    #[Asserts\NotBlank()]
    private ?string $url = null;

    public function getId(): ?int
        {
        return $this->id;
        }

    public function getName(): ?string
        {
        return $this->name;
        }

    public function setName(string $name): self
        {
        $this->name = $name;

        return $this;
        }

    public function getUrl(): ?string
        {
        return $this->url;
        }

    public function setUrl(string $url): self
        {
        $this->url = $url;

        return $this;
        }
    }