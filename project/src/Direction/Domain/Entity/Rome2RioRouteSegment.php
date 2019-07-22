<?php

namespace Direction\Domain\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * class Rome2RioRouteSegment
 */
class Rome2RioRouteSegment
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var Rome2RioRoute
     */
    private $route;

    /**
     * @var $cityId
     */
    private $cityId;


    /**
     * @var string
     *
     */
    private $segmentKind;

    /**
     * @var int
     *
     */
    private $distance;

    /**
     * @var int
     *
     */
    private $duration;

    /**
     * @var int
     */
    private $transferDuration;

    /**
     * @var float
     *
     */
    private $price;


    /**
     * @var string
     *
     */
    private $currency;

    /**
     * @var string
     */
    private $depPlaceLat;

    /**
     * @var string
     *
     */
    private $depPlaceLng;

    /**
     * @var string
     *
     *
     */
    private $depPlaceKind;

    /**
     * @var string
     *
     */
    private $depPlaceShortname;

    /**
     * @var string
     */
    private $arrPlaceLat;

    /**
     * @var string
     *
     */
    private $arrPlaceLng;

    /**
     * @var string
     *
     */
    private $arrPlaceKind;

    /**
     * @var string
     *
     */
    private $arrPlaceShortname;

    /**
     * @var string
     *
     */
    private $vehicleKind;

    /**
     * @var string
     */
    private $vehicleName;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $stops;

    /**
     * @var ArrayCollection
     */
    private $agencies;

    /**
     * @var ArrayCollection
     */
    private $flights;

    public function __construct(
        Rome2RioRoute $route,
        $cityId,
        $segmentKind,
        $distance,
        $duration,
        $transferDuration,
        $price,
        $currency,
        $depPlaceLat,
        $depPlaceLng,
        $depPlaceKind,
        $depPlaceCode,
        $depPlaceShortname,
        $arrPlaceLat,
        $arrPlaceLng,
        $arrPlaceKind,
        $arrPlaceCode,
        $arrPlaceShortname,
        $vehicleKind,
        $vehicleName,
        $path,
        $stops
    )
    {
        $this->route = $route;
        $this->cityId = $cityId;
        $this->segmentKind = $segmentKind;
        $this->distance = $distance;
        $this->duration = $duration;
        $this->transferDuration = $transferDuration;
        $this->price = $price;
        $this->currency = $currency;
        $this->depPlaceLat = $depPlaceLat;
        $this->depPlaceLng = $depPlaceLng;
        $this->depPlaceKind = $depPlaceKind;
        $this->depPlaceShortname = $depPlaceShortname;
        $this->arrPlaceLat = $arrPlaceLat;
        $this->arrPlaceLng = $arrPlaceLng;
        $this->arrPlaceKind = $arrPlaceKind;
        $this->arrPlaceShortname = $arrPlaceShortname;
        $this->vehicleKind = $vehicleKind;
        $this->vehicleName = $vehicleName;
        $this->path = $path;
        $this->stops = $stops;
        $this->agencies = new ArrayCollection();
        $this->flights = new ArrayCollection();
    }

    public function addAgency($agencyData)
    {
        $agency = new Rome2RioRouteSegmentAgency(
            $this,
            $agencyData['name'],
            $agencyData['url'],
            $agencyData['phone'],
            $agencyData['icon_url'],
            $agencyData['frequency'],
            $agencyData['duration'],
            $agencyData['link']['text'],
            $agencyData['link']['url'],
            $agencyData['link']['Rome2RioRouteSegmentdisplayUrl']
        );

        $this->agencies->add($agency);
    }

    public function addFlight($flight, $headsign)
    {
        if ($flight) {


            $segmentFlight = new Rome2RioRouteSegmentFlight(
                $this,
                $headsign
            );

            if ($flight['prices']) {
                foreach ($flight['prices'] as $price) {
                    $segmentFlight->addPrice($price);
                }
            }

            if ($flight['hops']) {
                foreach ($flight['hops'] as $hop) {
                    $segmentFlight->addHop($hop);
                }
            }

            $this->flights->add($segmentFlight);
        }

    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Rome2RioRoute
     */
    public function getRoute(): Rome2RioRoute
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * @return string
     */
    public function getSegmentKind()
    {
        return $this->segmentKind;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getTransferDuration()
    {
        return $this->transferDuration;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getDepPlaceLat()
    {
        return $this->depPlaceLat;
    }

    /**
     * @return string
     */
    public function getDepPlaceLng()
    {
        return $this->depPlaceLng;
    }

    /**
     * @return string
     */
    public function getDepPlaceKind()
    {
        return $this->depPlaceKind;
    }

    /**
     * @return string
     */
    public function getDepPlaceShortname()
    {
        return $this->depPlaceShortname;
    }


    /**
     * @return string
     */
    public function getArrPlaceLat()
    {
        return $this->arrPlaceLat;
    }



    /**
     * @return string
     */
    public function getArrPlaceLng()
    {
        return $this->arrPlaceLng;
    }


    /**
     * @return string
     */
    public function getArrPlaceKind()
    {
        return $this->arrPlaceKind;
    }

    /**
     * @return string
     */
    public function getArrPlaceShortname()
    {
        return $this->arrPlaceShortname;
    }

    /**
     * @return string
     */
    public function getVehicleKind()
    {
        return $this->vehicleKind;
    }

    /**
     * @return string
     */
    public function getVehicleName()
    {
        return $this->vehicleName;
    }

}