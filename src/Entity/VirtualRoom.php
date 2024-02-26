<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\VirtualRoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VirtualRoomRepository::class)]
#[ApiResource]
class VirtualRoom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $venID = null;

    #[ORM\Column(length: 255)]
    private ?string $mac = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clientAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dataRoom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video = null;

    #[ORM\Column]
    private ?bool $userDesc = null;

    #[ORM\Column]
    private ?bool $userName = null;

    #[ORM\Column]
    private ?bool $userPhoto = null;

    #[ORM\Column]
    private ?bool $userSpeciality = null;

    #[ORM\Column]
    private ?bool $venueName = null;

    #[ORM\Column(length: 20)]
    private ?string $turnOFFin = null;

    #[ORM\Column(length: 20)]
    private ?string $turnONin = null;

    #[ORM\Column(length: 255)]
    private ?string $background = null;

    #[ORM\Column(length: 255)]
    private ?string $docFree = null;

    #[ORM\Column(length: 255)]
    private ?string $docBusy = null;

    #[ORM\Column(length: 255)]
    private ?string $wait = null;

    #[ORM\Column(length: 255)]
    private ?string $userDescMaxLengthTex = null;

    #[ORM\Column(length: 255)]
    private ?string $userSpecialityMaxLengthText = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenID(): ?string
    {
        return $this->venID;
    }

    public function setVenID(string $venID): static
    {
        $this->venID = $venID;

        return $this;
    }

    public function getMac(): ?string
    {
        return $this->mac;
    }

    public function setMac(string $mac): static
    {
        $this->mac = $mac;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getClientAddress(): ?string
    {
        return $this->clientAddress;
    }

    public function setClientAddress(?string $clientAddress): static
    {
        $this->clientAddress = $clientAddress;

        return $this;
    }

    public function getDataRoom(): ?string
    {
        return $this->dataRoom;
    }

    public function setDataRoom(?string $dataRoom): static
    {
        $this->dataRoom = $dataRoom;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function isUserDesc(): ?bool
    {
        return $this->userDesc;
    }

    public function setUserDesc(bool $userDesc): static
    {
        $this->userDesc = $userDesc;

        return $this;
    }

    public function isUserName(): ?bool
    {
        return $this->userName;
    }

    public function setUserName(bool $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    public function isUserPhoto(): ?bool
    {
        return $this->userPhoto;
    }

    public function setUserPhoto(bool $userPhoto): static
    {
        $this->userPhoto = $userPhoto;

        return $this;
    }

    public function isUserSpeciality(): ?bool
    {
        return $this->userSpeciality;
    }

    public function setUserSpeciality(bool $userSpeciality): static
    {
        $this->userSpeciality = $userSpeciality;

        return $this;
    }

    public function isVenueName(): ?bool
    {
        return $this->venueName;
    }

    public function setVenueName(bool $venueName): static
    {
        $this->venueName = $venueName;

        return $this;
    }

    public function getTurnOFFin(): ?string
    {
        return $this->turnOFFin;
    }

    public function setTurnOFFin(string $turnOFFin): static
    {
        $this->turnOFFin = $turnOFFin;

        return $this;
    }

    public function getTurnONin(): ?string
    {
        return $this->turnONin;
    }

    public function setTurnONin(string $turnONin): static
    {
        $this->turnONin = $turnONin;

        return $this;
    }
    public function getBackground(): ?string
    {
        return $this->background;
    }
    public function setBackground(string $background): static
    {
        $this->background = $background;

        return $this;
    }

    public function getDocFree(): ?string
    {
        return $this->docFree;
    }

    public function setDocFree(string $docFree): static
    {
        $this->docFree = $docFree;

        return $this;
    }

    public function getDocBusy(): ?string
    {
        return $this->docBusy;
    }

    public function setDocBusy(string $docBusy): static
    {
        $this->docBusy = $docBusy;

        return $this;
    }

    public function getWait(): ?string
    {
        return $this->wait;
    }

    public function setWait(string $wait): static
    {
        $this->wait = $wait;

        return $this;
    }

    public function getUserDescMaxLengthTex(): ?string
    {
        return $this->userDescMaxLengthTex;
    }

    public function setUserDescMaxLengthTex(string $userDescMaxLengthTex): static
    {
        $this->userDescMaxLengthTex = $userDescMaxLengthTex;

        return $this;
    }

    public function getUserSpecialityMaxLengthText(): ?string
    {
        return $this->userSpecialityMaxLengthText;
    }

    public function setUserSpecialityMaxLengthText(string $userSpecialityMaxLengthText): static
    {
        $this->userSpecialityMaxLengthText = $userSpecialityMaxLengthText;

        return $this;
    }
}