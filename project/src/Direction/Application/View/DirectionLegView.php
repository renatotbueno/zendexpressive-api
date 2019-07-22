<?php

namespace Direction\Application\View;
use Direction\Domain\Collection\GoogleDirectionStepCollection;

/**
 * GoogleDirectionRouteLegView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class DirectionLegView
{

    private $distanceText;
    private $distanceValue;
    private $durationText;
    private $durationValue;
    private $startLocationLat;
    private $startLocationLng;
    private $endLocationLat;
    private $endLocationLng;
    private $startAddress;
    private $endAddress;
    private $departureTime;

    /** @var DirectionStepView */
    private $steps;

    public function __construct(
        $distanceText, $distanceValue,
        $durationText, $durationValue,
        $startLocationLat, $startLocationLng,
        $endLocationLat, $endLocationLng,
        $startAddress, $endAddress = null,
        $departureTimeText = null, $departureTimeValue = null,
        GoogleDirectionStepCollection $steps
    )
    {
        $this->distanceText = $distanceText;
        $this->distanceValue = $distanceValue;
        $this->durationText = $durationText;
        $this->durationValue = $durationValue;
        $this->startLocationLat = $startLocationLat;
        $this->startLocationLng = $startLocationLng;
        $this->endLocationLat = $endLocationLat;
        $this->endLocationLng = $endLocationLng;
        $this->startAddress = $startAddress;
        $this->endAddress = $endAddress;
        $this->departureTimeText = $departureTimeText;
        $this->departureTimeValue = $departureTimeValue;
        $this->steps = $steps;
    }

    public static function fromApiResponse($leg, GoogleDirectionStepCollection $steps)
    {
        return new static(
            $leg['distance']['text'], $leg['distance']['value'],
            $leg['duration']['text'], $leg['duration']['value'],
            $leg['start_location']['lat'], $leg['start_location']['lng'],
            $leg['end_location']['lat'], $leg['end_location']['lng'],
            $leg['start_address'], $leg['end_address'], //TODO testar end_address
            $leg['departure_time']['text'], $leg['departure_time']['value'], //TODO testar
            $steps
        );

    }

    public function distance()
    {
        return [
            'text' => $this->distanceText,
            'value' => $this->distanceValue,
        ];
    }

    public function toArray()
    {
        return [
            'distance' => [
                'text' => $this->distanceText,
                'value' => $this->distanceValue
            ],
            'duration' => [
                'text' => $this->durationText,
                'value' => $this->durationValue
            ],
            'start_location' => [
                'latitude' => $this->startLocationLat,
                'longitude' => $this->startLocationLng
            ],
            'end_location' => [
                'latitude' => $this->endLocationLat,
                'longitude' => $this->endLocationLng
            ],
            'start_address' => $this->startAddress,
            'end_address' => $this->endAddress,
            'departure_time' => [
                'text' => $this->departureTimeText,
                'value' => $this->departureTimeValue
            ],
            'steps' => $this->steps->toArray()
        ];
    }
}