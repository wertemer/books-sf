<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @var string
     * @ORM\Column(name="author", type="string", length=120, nullable=false)
     * 
     */
    private string $author;
    /**
     * @var string
     * @ORM\Column(name="name",type="string",length="120",nullable=false)
     */
    private string $name;
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="cdate", type="datetime",options={"default": "CURRENT_TIMESTAMP"},nullable=true)
     */
    private $cdate;
    /**
     * @var \Genres
     *
     * @ORM\ManyToOne(targetEntity="Genres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="f_genre", referencedColumnName="id")
     * })
     */
    private $fGenre;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function setAuthor(string $author): self
    {
        $this->author=$author;
        return $this;
    }
    public function getName() : ?string 
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name=$name;
        return $this;
    }
    public function getDate(): ?\DateTime
    {
        return $this->cdate;
    }
    public function setDate(\DateTime $date): self
    {
        $this->cdate=$date;
        return $this;
    }
    public function getFGenres(): ?Genres
    {
        return $this->fGenre;
    }
    public function setFGenres(?Genres $fGenres): self
    {
        $this->fGenre = $fGenres;

        return $this;
    }
}
