<?php

namespace App\Entity;

use App\Repository\ProjectCategoryReferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProjectCategoryReferenceRepository::class)]
class ProjectCategoryReference
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: "projectCategoryReference", targetEntity: ProjectCategoryReferenceStatus::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private iterable $statuses;

    #[ORM\ManyToOne(targetEntity: OrganizationUnit::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name:'organization_unit_id', nullable: false)]
    private ?OrganizationUnit $organizationUnit = null;

    public function __construct()
    {
        $this->statuses = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('#%s - %s', $this->getId(), $this->getLabel());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(ProjectCategoryReferenceStatus $status): self
    {
        $status->setProjectCategoryReference($this);
        if (!$this->statuses->contains($status)) {
            $this->statuses->add($status);
        }
        return $this;
    }

    public function removeStatus(ProjectCategoryReferenceStatus $status) : self
    {
        if ($this->statuses->contains($status)) {
            $this->statuses->removeElement($status);
        }
        return $this;
    }

    public function getOrganizationUnit(): ?OrganizationUnit
    {
        return $this->organizationUnit;
    }

    public function setOrganizationUnit(OrganizationUnit $organizationUnit): self
    {
        $this->organizationUnit = $organizationUnit;
        return $this;
    }
}
