<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\GoalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalRepository::class)]
class Goal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description de l'objectif est requise.")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: "La date limite est requise.")]
    #[Assert\Type("\DateTimeInterface", message: "La date n'est pas valide.")]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\ManyToOne(inversedBy: 'goals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le statut de l'objectif est requis.")]
    #[Assert\Choice(callback: ["App\Enum\GoalStatus", "getValues"], message: "Le statut de l'objectif n'est pas valide.")]
    private ?string $status = null;

    #[ORM\ManyToMany(targetEntity: WorkoutPlan::class, inversedBy: 'goals')]
    private Collection $workoutPlans;

    public function __construct()
    {
        $this->workoutPlans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutPlan>
     */
    public function getWorkoutPlans(): Collection
    {
        return $this->workoutPlans;
    }

    public function addWorkoutPlan(WorkoutPlan $workoutPlan): static
    {
        if (!$this->workoutPlans->contains($workoutPlan)) {
            $this->workoutPlans->add($workoutPlan);
        }

        return $this;
    }

    public function removeWorkoutPlan(WorkoutPlan $workoutPlan): static
    {
        $this->workoutPlans->removeElement($workoutPlan);

        return $this;
    }
}
