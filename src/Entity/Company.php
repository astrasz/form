<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"company"})
     */
    private $id;

    /**
     * @ORM\Column(type="bigint", unique=true)
     * @Assert\Regex(pattern="/^[0-9]{10}$/", message="NIP ma 10 cyfr")
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Groups({"company"})
     */
    private $nip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Groups({"company"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Groups({"company"})
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Groups({"company"})
     */
    private $house_nr;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"company"})
     */
    private $flat_nr;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Assert\Regex(pattern="/^[0-9]{2}-[0-9]{3}$/",message="Format kodu xx-xxx")
     * @Groups({"company"})
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Groups({"company"})
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Assert\Regex(pattern="/^[0-9]{9}$/",message="Numer ma 9 cyfr")
     * @Groups({"company"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\Email(message="To nie jest prawidłowy email")
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Groups({"company"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="companies", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $created_by;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): self
    {
        $this->nip = $nip;

        return $this;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNr(): ?string
    {
        return $this->house_nr;
    }

    public function setHouseNr(string $house_nr): self
    {
        $this->house_nr = $house_nr;

        return $this;
    }

    public function getFlatNr(): ?string
    {
        return $this->flat_nr;
    }

    public function setFlatNr(?string $flat_nr): self
    {
        $this->flat_nr = $flat_nr;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }
    

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }
}
