<?php

namespace Direction\Domain\Entity;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rome2RioRouteSegmentFlightPrice
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioRouteSegmentFlightPrice
{

    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var Rome2RioRouteSegmentFlight
     *
     */
    private $flight;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $priceLow;

    /**
     * @var string
     */
    private $priceHigh;

    /**
     * @var string
     */
    private $currency;


    public function __construct(
        Rome2RioRouteSegmentFlight $flight,
        $price,
        $priceLow,
        $priceHigh,
        $currency
    )
    {
        $this->flight = $flight;
        $this->price = $price;
        $this->priceLow = $priceLow;
        $this->priceHigh = $priceHigh;
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}