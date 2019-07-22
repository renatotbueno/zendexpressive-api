<?php

namespace Direction\Domain\Entity;
use Carbon\Carbon;

/**
 * Rome2RioRouteSegmentLegHopAgency
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioRouteSegmentAgency
{

    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var Rome2RioRouteSegment
     *
     */
    private $segment;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $url;

    /**
     * @var int
     */
    private $phone;

    /**
     * @var int
     */
    private $iconUrl;

    /**
     * @var float
     */
    private $frequency;

    /**
     * @var float
     */
    private $duration;

    /**
     * @var float
     */
    private $linkText;

    /**
     * @var string
     */
    private $linkUrl;

    /**
     * @var string
     */
    private $linkDisplayUrl;

    public function __construct(
        Rome2RioRouteSegment $segment,
        $name,
        $url,
        $phone,
        $iconUrl,
        $frequency,
        $duration,
        $linkText,
        $linkUrl,
        $linkDisplayUrl
    )
    {
        $this->segment = $segment;
        $this->name = $name;
        $this->url = $url;
        $this->phone = $phone;
        $this->iconUrl = $iconUrl;
        $this->frequency = $frequency;
        $this->duration = $duration;
        $this->linkText = $linkText;
        $this->linkUrl = $linkUrl;
        $this->linkDisplayUrl = $linkDisplayUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getUrl(): int
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getIconUrl(): int
    {
        return $this->iconUrl;
    }

    /**
     * @return float
     */
    public function getFrequency(): float
    {
        return $this->frequency;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function getLinkText(): float
    {
        return $this->linkText;
    }

    /**
     * @return string
     */
    public function getLinkUrl(): string
    {
        return $this->linkUrl;
    }

    /**
     * @return string
     */
    public function getLinkDisplayUrl(): string
    {
        return $this->linkDisplayUrl;
    }
}