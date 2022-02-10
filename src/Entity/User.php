<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="To nie jest prawidłowy email")
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Groups({"user"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180 )
     * @Assert\NotBlank(message="Uzupełnij pole")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=180 )
     * @Assert\NotBlank(message="Uzupełnij pole")
     */
    private $lastname;

    /**
     * @ORM\Column(type="bigint", unique=true)
     * @Assert\NotBlank(message="Uzupełnij pole")
     * @Assert\Regex(
     *     pattern="/^[0-9]{11}$/",
     *     message="PESEL ma 11 cyfr")
     */
    private $pesel;

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="created_by", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(string $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getCreatedBy() === $this) {
                $company->setCreatedBy(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        if(is_null($this->email)) {
            return '';
        }
        return $this->email;
    }
}
