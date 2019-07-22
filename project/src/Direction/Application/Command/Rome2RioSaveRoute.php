<?php

declare(strict_types=1);

namespace Direction\Application\Command;

use Jettyn\Core\ServiceBus\Command\CommandInterface;
use Webmozart\Assert\Assert;

class Rome2RioSaveRoute implements CommandInterface
{
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
     * @var array $segments
     */
    private $segments;

    /**
     * @var string
     *
     */
    private $name;

    /**
     * @var float
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
        $currency,
        $segments
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
        $this->segments = $segments;
    }

    public static function fromArray(array $data)
    {
        Assert::notEmpty($data['fromCityId'], "fromCityId is empty.");
        Assert::notEmpty($data['toCityId'], "toCityId is empty.");
        Assert::notEmpty($data['name'], "name is empty.");
        Assert::notEmpty($data['distance'], "distance is empty.");
        Assert::notEmpty($data['transitDuration'], "transitDuration is empty.");
        Assert::isArray($data['segments'], "Segments is empty.");
        Assert::isArray($data['indicativePrice'], "Indicative Price is empty.");

        return new self(
            $data['fromCityId'],
            $data['toCityId'],
            $data['name'],
            $data['distance'],
            $data['transitDuration'],
            $data['transferDuration'],
            $data['indicativePrice']['price'],
            $data['indicativePrice']['priceLow'],
            $data['indicativePrice']['priceHigh'],
            $data['indicativePrice']['currency'],
            $data['segments']
        );
    }

    public function toArray(): array
    {
        return [

        ];
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
     * @return array
     */
    public function getSegments(): array
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
     * @return float
     */
    public function getDistance(): float
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
    public function getPrice()
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
