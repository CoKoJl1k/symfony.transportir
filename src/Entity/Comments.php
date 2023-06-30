<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    use CreatedAtTrait,UpdatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $files = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?int $claims_id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Claims", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Claims $claims;

    public function getClaims(): ?Claims
    {
        return $this->claims;
    }
    public function setClaims(?Claims $claims): self
    {
        $this->claims = $claims;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function getFiles(): ?string
    {
        return $this->files;
    }

    public function setFiles(?string $files): static
    {
        $this->files = $files;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getClaimsId(): ?int
    {
        return $this->claims_id;
    }

    public function setClaimsId(int $claims_id): static
    {
        $this->claims_id = $claims_id;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->files;
    }

    public function setFile($files): static
    {
        $this->files = $files;
        return $this;
    }
}
