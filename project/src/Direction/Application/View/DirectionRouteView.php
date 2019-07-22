<?php

namespace Direction\Application\View;
use Direction\Domain\Collection\GoogleDirectionLegCollection;

/**
 * DirectionRouteView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class DirectionRouteView
{
    private $summary;
    private $warnnings;

    /** @var GoogleDirectionLegCollection */
    private $legs;

    public function __construct(
        $summary = null,
        $warnnings = null,
        GoogleDirectionLegCollection $legs = null
    )
    {
        $this->summary = $summary;
        $this->warnnings = $warnnings;
        $this->legs = $legs;
    }

    public static function fromApiResponse($route, GoogleDirectionLegCollection $legs = null)
    {
        return new static(
            $route['summary'],
            $route['warnings'],
            $legs
        );
    }

    public function legs()
    {
        return $this->legs;
    }

    public function toArray()
    {
        return [
            'summary' => $this->summary,
            'warnings' => $this->warnnings,
            'legs' => $this->legs->toArray()
        ];
    }
}