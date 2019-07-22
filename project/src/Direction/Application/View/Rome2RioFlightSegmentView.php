<?php

namespace Direction\Application\View;

/**
 * FlightAgentView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioFlightSegmentView
{
    private $prices;
    private $hops;

    public function __construct(
        $prices,
        $hops
    )
    {
        $this->prices = $prices;
        $this->hops = $hops;
    }

    /**
     * [fromApiResponse description]
     * @param  [type] $outbound [description]
     * @return [type]           [description]
     */
    public static function fromApiResponse($segment)
    {
        $hops = [];
        if ($segment['hops']) {
            foreach ($segment['hops'] as $hop) {
                $hops[] = Rome2RioFlightSegmentHopView::fromApiResponse($hop)->toArray();
            }
        }

        return new static(
            $segment['indicativePrices'],
            $hops
        );
    }

    public function toArray()
    {
        return [
            'prices' => $this->prices,
            'hops' => $this->hops
        ];
    }
}
