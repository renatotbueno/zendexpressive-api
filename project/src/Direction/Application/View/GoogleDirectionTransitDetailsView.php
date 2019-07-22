<?php

namespace Direction\Application\View;

/**
 * GoogleDirectionRouteLegStepTransitDetailsView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class GoogleDirectionTransitDetailsView
{

    private $departureStopName;
    private $departureTimeText;
    private $departureTimeValue;
    private $arrivalStopName;
    private $arrivalTimeText;
    private $arrivalTimeValue;
    private $headsign;
    private $numStops;

    /** @var DirectionLineView  */
    private $line;

    public function __construct(
        $departureStopName = null,
        $departureTimeText = null, $departureTimeValue = null,
        $arrivalStopName = null,
        $arrivalTimeText = null, $arrivalTimeValue = null,
        $headsign = null,
        $numStops = null,
        DirectionLineView $line = null
    )
    {
        $this->departureStopName = $departureStopName;
        $this->departureTimeText = $departureTimeText;
        $this->departureTimeValue = $departureTimeValue;
        $this->arrivalStopName = $arrivalStopName;
        $this->arrivalTimeText = $arrivalTimeText;
        $this->arrivalTimeValue = $arrivalTimeValue;
        $this->headsign = $headsign;
        $this->numStops = $numStops;
        $this->line = $line;
    }

    public static function fromApiResponse($transitDetails, DirectionLineView $line = null)
    {

        if (!$transitDetails) {
            return new static();
        }

        return new static(
            $transitDetails['departure_stop']['name'],
            $transitDetails['departure_time']['text'], $transitDetails['departure_time']['value'],
            $transitDetails['arrival_stop']['name'],
            $transitDetails['arrival_time']['text'], $transitDetails['arrival_time']['value'],
            $transitDetails['headsign'],
            $transitDetails['num_stops'],
            $line
        );
    }


    public function toArray()
    {
        return [
            'departure_stop_name' => $this->departureStopName,
            'departure_time' => [
                'text' => $this->departureTimeText,
                'value' => $this->departureTimeValue
            ],
            'arrival_stop_name' => $this->arrivalStopName,
            'arrival_time' => [
                'text' => $this->arrivalTimeText,
                'value' => $this->arrivalTimeValue
            ],
            'headsign' => $this->headsign,
            'num_stops' => $this->numStops,
            'lines' => !empty($this->line) ? $this->line->toArray() : []
        ];
    }
}