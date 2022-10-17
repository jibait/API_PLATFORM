<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"},
 *     attributes={"pagination_enabled" = false},
 * )
 * 
 * @ApiFilter(searchFilter::class, properties={
 *     "name" = searchFilter::STRATEGY_PARTIAL,
 * })
 * 
 * @ApiFilter(OrderFilter::class, properties={
 *     "name"
 * }, arguments={
 *     "orderParameterName" = "order"
 * })
 * @ORM\Entity(repositoryClass=App\Repository\GenreRepository::class)
 */
class Genre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"collection", "item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"collection", "item"})
     * @NotBlank
     * @Length(min= 3)
     */
    private $name;

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
}
