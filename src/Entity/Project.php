<?php

namespace App\Entity;

use App\Abstracts\AModel;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project extends AModel
{
    protected array $fillable = [
        'title' => 'setTitle',
        'client' => 'setClient',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Название проекта не может быть пустым")]
    private ?string $title;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Клиент не может быть пустым")]
    private ?string $client;

    /**
     * @var Collection<int, Developer>
     */
    #[ORM\OneToMany(targetEntity: Developer::class, mappedBy: 'project')]
    #[Assert\NotBlank(message: "Проект не может быть пустым")]
    private Collection $developers;

    #[ORM\Column]
    private ?bool $is_active = true;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->developers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDevelopers(): Collection
    {
        return $this->developers;
    }

    public function addDeveloper(Developer $developer): static
    {
        if (!$this->developers->contains($developer)) {
            $this->developers->add($developer);
            $developer->setProject($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): static
    {
        if ($this->developers->removeElement($developer)) {
            // set the owning side to null (unless already changed)
            if ($developer->getProject() === $this) {
                $developer->setProject(null);
            }
        }

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }
}
