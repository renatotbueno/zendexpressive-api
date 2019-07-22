<?php

namespace Direction\Application\View;

/**
 * Rome2RioFlightSegmentHopView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioFlightSegmentHopView
{
    private $depPlace;
    private $arrPlace;
    private $arrTerminal;
    private $depTime;
    private $arrTime;
    private $flight;
    private $airline;
    private $duration;
    private $aircraft;
    private $codeshares;

    public function __construct(
        $depPlace,
        $arrPlace,
        $arrTerminal,
        $depTime,
        $arrTime,
        $flight,
        $airline,
        $duration,
        $aircraft,
        $codeshares = []
    )
    {
        $this->depPlace = $depPlace;
        $this->arrPlace = $arrPlace;
        $this->arrTerminal = $arrTerminal;
        $this->depTime = $depTime;
        $this->arrTime = $arrTime;
        $this->flight = $flight;
        $this->airline = $airline;
        $this->duration = $duration;
        $this->aircraft = $aircraft;
        $this->codeshares = $codeshares;
    }

    /**
     * [fromApiResponse description]
     * @param  [type] $outbound [description]
     * @return [type]           [description]
     */
    public static function fromApiResponse($hop)
    {
        return new static(
            $hop['depPlace'],
            $hop['arrPlace'],
            $hop['arrTerminal'],
            $hop['depTime'],
            $hop['arrTime'],
            $hop['flight'],
            $hop['airline'],
            $hop['duration'],
            $hop['aircraft'],
            $hop['codeshares']
        );
    }

    public function toArray()
    {
        return [
            'depPlace' => $this->depPlace,
            'arrPlace' => $this->arrPlace,
            'arrTerminal' => $this->arrTerminal,
            'depTime' => $this->depTime,
            'arrTime' => $this->arrTime,
            'flight' => $this->flight,
            'airline' => $this->airline,
            'duration' => $this->duration,
            'aircraft' => $this->aircraft,
            'codeshares' => $this->codeshares
        ];
    }
}
