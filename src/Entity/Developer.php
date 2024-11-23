<?php

namespace App\Entity;

use App\Abstracts\AModel;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer extends AModel
{
    protected array $fillable = 
    [
        'name' => 'setName',
        'position' => 'setPosition',
        'email' => 'setEmail',
        'phone' => 'setPhone',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Имя сотрудника не может быть пустым")]
    #[Assert\Length(max: 255, maxMessage: "Имя пользователя не может быть длиннее {{ limit }} символов")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Должность не может быть пустой")]
    #[Assert\Length(max: 255, maxMessage: "Должность не может быть длиннее {{ limit }} символов")]
    private ?string $position = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Почта не может быть пустой")]
    #[Assert\Email(message: "Некорректный формат email")]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Телефон не может быть пустым")]
    #[Assert\Regex(
        pattern: "/^\+?[0-9\s\-]{7,20}$/",
        message: "Телефон должен быть в международном формате"
    )]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'developers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
