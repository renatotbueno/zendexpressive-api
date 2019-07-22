<?php

namespace Direction\Application\View;

use Direction\Domain\Collection\GoogleDirectionStepCollection;

/**
 * DirectionStepView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class DirectionStepView
{

    private $distanceText;
    private $distanceValue;
    private $durationText;
    private $durationValue;
    private $startLocationLat;
    private $startLocationLng;
    private $endLocationLat;
    private $endLocationLng;
    private $htmlInstructions;
    private $travelMode;
    private $path;

    /**
     * @var GoogleDirectionTransitDetailsView
     */
    private $transitDetails;

    /**
     * @var GoogleDirectionStepCollection
     */
    private $steps;

    public function __construct(
        $distanceText, $distanceValue,
        $durationText, $durationValue,
        $startLocationLat, $startLocationLng,
        $endLocationLat, $endLocationLng,
        $htmlInstructions,
        $travelMode,
        $path,
        $transitDetails,
        $steps
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
        $this->htmlInstructions = $htmlInstructions;
        $this->travelMode = $travelMode;
        $this->path = $path;
        $this->transitDetails = $transitDetails;
        $this->steps = $steps;
    }

    public static function fromApiResponse(
        $step,
        GoogleDirectionTransitDetailsView $transitDetails = null,
        GoogleDirectionStepCollection $steps = null)
    {
        return new static(
            $step['distance']['text'], $step['distance']['value'],
            $step['duration']['text'], $step['duration']['value'],
            $step['start_location']['lat'], $step['start_location']['lng'],
            $step['end_location']['lat'], $step['end_location']['lng'],
            isset($step['html_instructions']) ? $step['html_instructions'] : null,
            isset($step['travel_mode']) ? $step['travel_mode'] : null,
            $step['polyline']['points'],
            $transitDetails,
            $steps
        );
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
            'html_instructions' => $this->htmlInstructions,
            'travel_mode' => $this->travelMode,
            'path' => $this->path,
            'transit_details' => ($this->transitDetails != null) ? $this->transitDetails->toArray() : [],
            'steps' => ($this->steps != null) ? $this->steps->toArray() : []
        ];
    }
}