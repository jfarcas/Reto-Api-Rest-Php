<?php

namespace App\Entity;

use App\Repository\JokeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JokeRepository::class)
 */
class Joke
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $number;

    /**
     * @ORM\Column(type="string", length=4000)
     *
     * @Assert\Length(
     *      min= 10,
     *     max= 400,
     *     minMessage= "Joke length must be at least {{ limit }} characters long",
     *     maxMessage = "Joke length  cannot be longer than {{ limit }} characters"
     *     )
     */
    private string $joke;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotNull()
     * * @Assert\Length(
     *      min= 3,
     *     max= 20,
     *     minMessage= "Joke type must be at least {{ limit }} characters long",
     *     maxMessage = "Joke type cannot be longer than {{ limit }} characters"
     *     )
     */
    private string $type = 'custom';

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getJoke(): ?string
    {
        return $this->joke;
    }

    public function setJoke(string $joke): self
    {
        $this->joke = $joke;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setNumber(int $number)
    {
        $this->number = $number;
    }
}
