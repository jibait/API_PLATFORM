<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"},
 *     attributes={"pagination_enabled" = false},
 * )
 * 
 * @ApiFilter(searchFilter::class, properties={
 *     "firstName" = searchFilter::STRATEGY_PARTIAL,
 *     "lastName" = searchFilter::STRATEGY_PARTIAL,
 * })
 * 
 * @ApiFilter(OrderFilter::class, properties={
 *     "firstName", "lastName"
 * }, arguments={
 *     "orderParameterName" = "order"
 * })
 * 
 * @ORM\Entity(repositoryClass=App\Repository\PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @NotBlank
     * @Groups({"item"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @NotBlank
     * @NotIdenticalTo(propertyPath= "firstName")
     * @Groups({"item"})
     */
    private $lastName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}