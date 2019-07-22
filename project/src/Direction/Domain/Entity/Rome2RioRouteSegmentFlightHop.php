<?php

namespace Direction\Domain\Entity;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rome2RioRouteSegmentFlightHop
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioRouteSegmentFlightHop
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

    private $depPlaceLat;
    private $depPlaceLng;
    private $depPlaceKind;
    private $depPlaceCode;
    private $depPlaceTimezone;
    private $depPlaceShortname;
    private $arrPlaceLat;
    private $arrPlaceLng;
    private $arrPlaceKind;
    private $arrPlaceCode;
    private $arrPlaceTimezone;
    private $arrPlaceShortname;
    private $arrTerminal;
    private $depTime;
    private $arrTime;
    private $flightNumber;
    private $duration;
    private $airlineCode;
    private $airlineName;
    private $airlineUrl;
    private $airlineIcon;
    private $aircraftCode;
    private $aircraftManufacturer;
    private $aircraftModel;
    private $codeshare;


    public function __construct(
        Rome2RioRouteSegmentFlight $flight,
        $depPlaceLat,
        $depPlaceLng,
        $depPlaceKind,
        $depPlaceCode,
        $depPlaceTimezone,
        $depPlaceShortname,
        $arrPlaceLat,
        $arrPlaceLng,
        $arrPlaceKind,
        $arrPlaceCode,
        $arrPlaceTimezone,
        $arrPlaceShortname,
        $arrTerminal,
        $depTime,
        $arrTime,
        $flightNumber,
        $duration,
        $airlineCode,
        $airlineName,
        $airlineUrl,
        $airlineIcon,
        $aircraftCode,
        $aircraftManufacturer,
        $aircraftModel,
        $codeshare
    )
    {
        $this->flight = $flight;
        $this->depPlaceLat = $depPlaceLat;
        $this->depPlaceLng = $depPlaceLng;
        $this->depPlaceKind = $depPlaceKind;
        $this->depPlaceCode = $depPlaceCode;
        $this->depPlaceTimezone = $depPlaceTimezone;
        $this->depPlaceShortname = $depPlaceShortname;
        $this->arrPlaceLat = $arrPlaceLat;
        $this->arrPlaceLng = $arrPlaceLng;
        $this->arrPlaceKind = $arrPlaceKind;
        $this->arrPlaceCode = $arrPlaceCode;
        $this->arrPlaceTimezone = $arrPlaceTimezone;
        $this->arrPlaceShortname = $arrPlaceShortname;
        $this->arrTerminal = $arrTerminal;
        $this->depTime = $depTime;
        $this->arrTime = $arrTime;
        $this->flightNumber = $flightNumber;
        $this->duration = $duration;
        $this->airlineCode = $airlineCode;
        $this->airlineName = $airlineName;
        $this->airlineUrl = $airlineUrl;
        $this->airlineIcon = $airlineIcon;
        $this->aircraftCode = $aircraftCode;
        $this->aircraftManufacturer = $aircraftManufacturer;
        $this->aircraftModel = $aircraftModel;
        $this->codeshare = $codeshare;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}