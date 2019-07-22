<?php

namespace Direction\Domain\Entity;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rome2RioRouteSegmentFlight
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioRouteSegmentFlight
{

    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var Rome2RioRouteSegment
     *
     */
    private $segment;

    /**
     * @var string
     */
    private $headsign;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var array
     */
    private $flight;

    /**
     * @var ArrayCollection
     */
    private $prices;

    /**
     * @var ArrayCollection
     */
    private $hops;

    public function __construct(
        Rome2RioRouteSegment $segment,
        $headsign
    )
    {
        $this->segment = $segment;
        $this->headsign = $headsign;
        $this->prices = new ArrayCollection();
        $this->hops = new ArrayCollection();
    }

    public function addPrice($price)
    {
        $flightPrice = new Rome2RioRouteSegmentFlightPrice(
            $this,
            $price['price'],
            $price['priceLow'],
            $price['priceHigh'],
            $price['currency']
        );

        $this->prices->add($flightPrice);
    }

    public function addHop($hop)
    {
        $flightHop = new Rome2RioRouteSegmentFlightHop(
            $this,
            $hop['depPlace']['lat'],
            $hop['depPlace']['lng'],
            $hop['depPlace']['kind'],
            isset($hop['depPlace']['code']) ? $hop['depPlace']['code'] : '',
            $hop['depPlace']['timeZone'],
            $hop['depPlace']['shortName'],
            $hop['arrPlace']['lat'],
            $hop['arrPlace']['lng'],
            $hop['arrPlace']['kind'],
            isset($hop['arrPlace']['code']) ? $hop['arrPlace']['code'] : '',
            $hop['arrPlace']['timeZone'],
            $hop['arrPlace']['shortName'],
            $hop['arrTerminal'],
            $hop['depTime'],
            $hop['arrTime'],
            $hop['flight'],
            $hop['duration'],
            $hop['airline']['code'],
            $hop['airline']['name'],
            $hop['airline']['url'],
            isset($hop['airline']['icon']) ? json_encode($hop['airline']['icon']) : '',
            $hop['aircraft']['code'],
            $hop['aircraft']['manufacturer'],
            $hop['aircraft']['model'],
            isset($hop['codeshares']) ? json_encode($hop['codeshares']) : ''
        );

        $this->hops->add($flightHop);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * @return string
     */
    public function getHeadsign()
    {
        return $this->headsign;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}