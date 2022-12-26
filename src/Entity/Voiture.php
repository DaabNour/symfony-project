<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Serie;

    /**
     * @ORM\Column(type="date")
     */
    private $date_mise;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private $marche;



    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="voiture")
     */
    private $locations;

    /**
     * @ORM\ManyToOne(targetEntity=Modele::class, inversedBy="relation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $libelle;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerie(): ?int
    {
        return $this->Serie;
    }

    public function setSerie(int $Serie): self
    {
        $this->Serie = $Serie;

        return $this;
    }

    public function getDateMise(): ?\DateTimeInterface
    {
        return $this->date_mise;
    }

    public function setDateMise(\DateTimeInterface $date_mise): self
    {
        $this->date_mise = $date_mise;

        return $this;
    }

    public function getMarche(): ?string
    {
        return $this->marche;
    }

    public function setMarche(string $marche): self
    {
        $this->marche = $marche;

        return $this;
    }



    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?Modele
    {
        return $this->libelle;
    }

    public function setLibelle(?Modele $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    
    
}
