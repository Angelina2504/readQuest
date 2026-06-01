<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $book_name = null;

    #[ORM\Column(length: 13)]
    private ?string $book_isbn = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $book_publication = null;

    #[ORM\Column]
    private ?int $book_page = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $book_cover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $book_description = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $book_language = null;

    /**
     * @var Collection<int, Autor>
     */
    #[ORM\ManyToMany(targetEntity: Autor::class, inversedBy: 'books')]
    private Collection $autors;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'books')]
    private Collection $genres;

    /**
     * @var Collection<int, Reading>
     */
    #[ORM\OneToMany(targetEntity: Reading::class, mappedBy: 'book')]
    private Collection $readings;

    public function __construct()
    {
        $this->autors = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->readings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookName(): ?string
    {
        return $this->book_name;
    }

    public function setBookName(string $book_name): static
    {
        $this->book_name = $book_name;

        return $this;
    }

    public function getBookIsbn(): ?string
    {
        return $this->book_isbn;
    }

    public function setBookIsbn(string $book_isbn): static
    {
        $this->book_isbn = $book_isbn;

        return $this;
    }

    public function getBookPublication(): ?string
    {
        return $this->book_publication;
    }

    public function setBookPublication(?string $book_publication): static
    {
        $this->book_publication = $book_publication;

        return $this;
    }

    public function getBookPage(): ?int
    {
        return $this->book_page;
    }

    public function setBookPage(int $book_page): static
    {
        $this->book_page = $book_page;

        return $this;
    }

    public function getBookCover(): ?string
    {
        return $this->book_cover;
    }

    public function setBookCover(?string $book_cover): static
    {
        $this->book_cover = $book_cover;

        return $this;
    }

    public function getBookDescription(): ?string
    {
        return $this->book_description;
    }

    public function setBookDescription(?string $book_description): static
    {
        $this->book_description = $book_description;

        return $this;
    }

    public function getBookLanguage(): ?string
    {
        return $this->book_language;
    }

    public function setBookLanguage(?string $book_language): static
    {
        $this->book_language = $book_language;

        return $this;
    }

    /**
     * @return Collection<int, Autor>
     */
    public function getAutors(): Collection
    {
        return $this->autors;
    }

    public function addAutor(Autor $autor): static
    {
        if (!$this->autors->contains($autor)) {
            $this->autors->add($autor);
        }

        return $this;
    }

    public function removeAutor(Autor $autor): static
    {
        $this->autors->removeElement($autor);

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Reading>
     */
    public function getReadings(): Collection
    {
        return $this->readings;
    }

    public function addReading(Reading $reading): static
    {
        if (!$this->readings->contains($reading)) {
            $this->readings->add($reading);
            $reading->setBook($this);
        }

        return $this;
    }

    public function removeReading(Reading $reading): static
    {
        if ($this->readings->removeElement($reading)) {
            // set the owning side to null (unless already changed)
            if ($reading->getBook() === $this) {
                $reading->setBook(null);
            }
        }

        return $this;
    }
}
