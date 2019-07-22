<?php

namespace Direction\Domain\Entity;

/**
 * class DirectionPrice
 */
class DirectionPrice
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     */
    private $cityId;

    /**
     * @var string
     */
    private $station;


    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $duration;

    /**
     * @var
     */
    private $quantityTickets;

    /**
     * @var
     */
    private $price;

    /**
     * @var string
     */
    private $stops;

    public function __construct(
        $id,
        $cityId,
        $station,
        $type,
        $stops,
        $price,
        $duration,
        $quantityTickets
    ) {
        $this->id = $id;
        $this->cityId = $cityId;
        $this->station = $station;
        $this->type = $type;
        $this->stops = $stops;
        $this->price = $price;
        $this->quantityTickets = $quantityTickets;
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCityId(): string
    {
        return $this->cityId;
    }

    /**
     * @return string
     */
    public function getStation(): string
    {
        return $this->station;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getQuantityTickets()
    {
        return $this->quantityTickets;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getStops(): string
    {
        return $this->stops;
    }

}

