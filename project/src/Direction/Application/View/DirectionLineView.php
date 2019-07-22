<?php

namespace Direction\Application\View;

/**
 * GoogleDirectionRouteLegStepTransitDetailsView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class DirectionLineView
{
    private $name;
    private $shortName;
    private $color;
    private $textColor;

    /**
     * @var GoogleDirectionVechicleView
     */
    private $vehicle;

    public function __construct(
        $name = null,
        $shortName = null,
        $color = null,
        $textColor = null,
        GoogleDirectionVechicleView $vehicle = null
    )
    {
        $this->name = $name;
        $this->shortName = $shortName;
        $this->color = $color;
        $this->textColor = $textColor;
        $this->vehicle = $vehicle;
    }

    public static function fromApiResponse($line, GoogleDirectionVechicleView $vehicle = null)
    {
        if ( !$line ) {
            return new static();
        }

        return new static(
            $line['name'],
            $line['short_name'],
            $line['color'],
            $line['text_color'],
            $vehicle
        );
    }


    public function toArray()
    {
        return [
            'name' => $this->name,
            'short_name' => $this->shortName,
            'color' => $this->color,
            'text_color' => $this->textColor,
            'vechile' => $this->vehicle->toArray()
        ];
    }
}