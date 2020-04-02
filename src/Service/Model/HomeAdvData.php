<?php
namespace App\Service\Model;


class HomeAdvData
{
    private $id;
    private $price;
    private $numericPrice;
    private $size;
    private $roomNumber;
    private $floor;
    private $buildingFloor;
    private $airConditioning;
    private $description;
    private $agentName;

    public function __construct(string $id, string $price, string $size)
    {
        $this->id = $id;
        $this->price = $price;
        $this->size = $size;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getRoomNumber(): ?string
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(?string $roomNumber): self
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getBuildingFloor(): ?int
    {
        return $this->buildingFloor;
    }

    public function setBuildingFloor(?int $buildingFloor): self
    {
        $this->buildingFloor = $buildingFloor;

        return $this;
    }

    public function getAirConditioning(): ?bool
    {
        return $this->airConditioning;
    }

    public function setAirConditioning(bool $airConditioning): self
    {
        $this->airConditioning = $airConditioning;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumericPrice(): float
    {
        return $this->numericPrice;
    }

    public function setNumericPrice(float $numericPrice): self
    {
        $this->numericPrice = $numericPrice;

        return $this;
    }

    public function getAgentName(): ?string
    {
        return $this->agentName;
    }

    public function setAgentName(?string $agentName): self
    {
        $this->agentName = $agentName;

        return $this;
    }
}