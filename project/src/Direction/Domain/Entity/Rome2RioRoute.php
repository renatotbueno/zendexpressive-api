<?php

namespace Direction\Domain\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * class Rome2RioRoute
 */
class Rome2RioRoute
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var $originCityId
     *
     */
    private $originCityId;

    /**
     * @var $destinationCityId
     */
    private $destinationCityId;

    /**
     * @var ArrayCollection $segments
     */
    private $segments;

    /**
     * @var string
     *
     */
    private $name;

    /**
     * @var int
     *
     */
    private $distance;

    /**
     * @var int
     *
     */
    private $totalDuration;

    /**
     * @var int
     *
     */
    private $totalTransferDuration;

    /**
     * @var float
     *
     */
    private $price;

    /**
     * @var float
     *
     */
    private $priceLow;

    /**
     * @var float
     *
     */
    private $priceHigh;

    /**
     * @var string
     *
     */
    private $currency;

    public function __construct(
        $originCityId,
        $destinationCityId,
        $name,
        $distance,
        $totalDuration,
        $totalTransferDuration,
        $price,
        $priceLow,
        $priceHigh,
        $currency
    ) {
        $this->originCityId = $originCityId;
        $this->destinationCityId = $destinationCityId;
        $this->name = $name;
        $this->distance = $distance;
        $this->totalDuration = $totalDuration;
        $this->totalTransferDuration = $totalTransferDuration;
        $this->price = $price;
        $this->priceLow = $priceLow;
        $this->priceHigh = $priceHigh;
        $this->currency = $currency;
        $this->segments = new ArrayCollection();
    }

    public function addSegment($segmentData)
    {
        $indicativePrice = current($segmentData['indicativePrice']);
      
        $segment = new Rome2RioRouteSegment(
            $this,
            $segmentData['city_id'],
            $segmentData['segmentKind'],
            $segmentData['distance'],
            $segmentData['transitDuration'],
            $segmentData['transferDuration'],
            $indicativePrice['price'],
            $indicativePrice['currency'],
            $segmentData['depPlace']['lat'],
            $segmentData['depPlace']['lng'],
            $segmentData['depPlace']['kind'],
            (isset( $segmentData['depPlace']['code'])) ? $segmentData['depPlace']['code'] : '',
            $segmentData['depPlace']['shortName'],
            $segmentData['arrPlace']['lat'],
            $segmentData['arrPlace']['lng'],
            $segmentData['arrPlace']['kind'],
            (isset( $segmentData['arrPlace']['code'])) ? $segmentData['arrPlace']['code'] : '',
            $segmentData['arrPlace']['shortName'],
            $segmentData['vehicle']['kind'],
            $segmentData['vehicle']['name'],
            $segmentData['path'],
            isset($segmentData['stops']) && !empty($segmentData['stops']) ? json_encode($segmentData['stops']) : ''
        );

        if ($segmentData['agencies']) {
            foreach ($segmentData['agencies'] as $agencyData) {
                $segment->addAgency($agencyData);
            }
        }

        if ($segmentData['outbound']) {
            foreach ($segmentData['outbound'] as $outbound) {
                $segment->addFlight($outbound, 'outbound');
            }
        }

        if ($segmentData['return']) {
            foreach ($segmentData['return'] as $outbound) {
                $segment->addFlight($outbound, 'return');
            }
        }

        $this->segments->add($segment);
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
    public function getOriginCityId()
    {
        return $this->originCityId;
    }

    /**
     * @return mixed
     */
    public function getDestinationCityId()
    {
        return $this->destinationCityId;
    }

    /**
     * @return mixed
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @return int
     */
    public function getTotalDuration(): int
    {
        return $this->totalDuration;
    }

    /**
     * @return int
     */
    public function getTotalTransferDuration(): int
    {
        return $this->totalTransferDuration;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getPriceLow(): float
    {
        return $this->priceLow;
    }

    /**
     * @return float
     */
    public function getPriceHigh(): float
    {
        return $this->priceHigh;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}

