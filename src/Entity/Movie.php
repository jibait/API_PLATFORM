<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get" ={
 *             "normalization_context" ={"groups"= {"collection"}}
 *         },
 *         "post",
 *         "random" ={
 *             "controller"= RandomMovie::class,
 *             "path"="/movies/random",
 *             "output"= Movie::class,
 *             "method"= Request::METHOD_GET,
 *             "pagination_enabled" = false,
 *             "normalization_context" ={"groups"= {"item"}}
 *         },
 *     },
 *     itemOperations={
 *         "get" ={
 *             "normalization_context" ={"groups"= {"item"}}
 *         },
 *         "put", "delete"
 *     },
 *     denormalizationContext={"groups"= {"write"}}
 * )
 * @ORM\Entity(repositoryClass=App\Repository\MovieRepository::class)
 */
class Movie
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
     * @Groups({"collection", "item", "write"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"collection", "item", "write"})
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"collection", "item", "write"})
     */
    private $productionYear;

    /**
     * @ORM\Column(type="text")
     * @Groups({"collection", "item", "write"})
     */
    private $synopsis;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"collection", "item", "write"})
     */
    private $genre;

    /**
     * @ORM\ManyToMany(targetEntity=Person::class)
     * @ORM\JoinTable(name="movie_actors")
     * @ApiSubresource
     * @Groups({"item", "write"})
     */
    private $actors;

    /**
     * @ORM\ManyToMany(targetEntity=Person::class)
     * @ORM\JoinTable(name="movie_directors")
     * @ApiSubresource
     * @Groups({"item", "write"})
     */
    private $directors;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->directors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getProductionYear(): ?int
    {
        return $this->productionYear;
    }

    public function setProductionYear(int $productionYear): self
    {
        $this->productionYear = $productionYear;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    public function addDirector(Person $director):self{
        if(!$this->directors->contains($director)){
            $this->directors[] = $director;
        }
        return $this;
    }

    public function removeDirector(Person $director):self{
        $this->directors->removeElement($director);
        return $this;
    }

    public function addActor(Person $actors):self{
        if(!$this->actors->contains($actors)){
            $this->actors[] = $actors;
        }
        return $this;
    }

    public function removeActor(Person $actors):self{
        $this->actors->removeElement($actors);
        return $this;
    }
}
