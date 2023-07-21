<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RateRepository::class)]
#[ORM\Table(name: 'rates')]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false, insertable: false, updatable: false)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false, insertable: false, updatable: false)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dt = null;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $base_currency = null;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $quote_currency = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 1000, scale: 8, nullable: false)]
    private ?string $factor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDt(): ?\DateTimeInterface
    {
        return $this->dt;
    }

    public function setDt(\DateTimeInterface $dt): static
    {
        $this->dt = $dt;

        return $this;
    }

    public function getBaseCurrency(): ?string
    {
        return $this->base_currency;
    }

    public function setBaseCurrency(string $base_currency): static
    {
        $this->base_currency = $base_currency;

        return $this;
    }

    public function getQuoteCurrency(): ?string
    {
        return $this->quote_currency;
    }

    public function setQuoteCurrency(string $quote_currency): static
    {
        $this->quote_currency = $quote_currency;

        return $this;
    }

    public function getFactor(): ?string
    {
        return $this->factor;
    }

    public function setFactor(string $factor): static
    {
        $this->factor = $factor;

        return $this;
    }
}
