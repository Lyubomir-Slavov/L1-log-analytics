<?php

namespace App\Entity;

use App\Repository\LogEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
class LogEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[SerializedName('0')]
    #[ORM\Column(length: 255, nullable: false)]
    private string $serviceName;

    #[SerializedName('1')]
    #[Context(
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/M/Y:H:i:s O'],
    )]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: false)]
    private \DateTimeImmutable $date;

    #[SerializedName('3')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $statusCode;

    #[SerializedPath('[2][0]')]
    #[ORM\Column(type:Types::STRING, length: 255, nullable: false)]
    private string $requestMethod;

    #[SerializedPath('[2][1]')]
    #[ORM\Column(type:Types::STRING, length: 255, nullable: false)]
    private string $route;

    #[SerializedPath('[2][2]')]
    #[ORM\Column(type:Types::STRING, length: 255, nullable: false)]
    private string $protocol;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): static
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(string $requestMethod): static
    {
        $this->requestMethod = $requestMethod;

        return $this;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol): static
    {
        $this->protocol = $protocol;

        return $this;
    }
}
