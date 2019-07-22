<?php

namespace Direction\Domain\Entity;

/**
 * Rome2RioRequest
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class Rome2RioRequest
{
    /** @var string */
    private $currency;

    /** @var string */
    private $language;

    /** @var string */
    private $oName;

    /** @var string */
    private $dName;

    /** @var string */
    private $oLatitude;

    /** @var string */
    private $oLongitude;

    /** @var string */
    private $dLatitude;

    /** @var string */
    private $dLongitude;

    public function __construct(
        $language,
        $currency,
        $oLat = null, $oLng = null,
        $dLat = null, $dLng = null,
        $oName = null, $dName = null
    )
    {
        $this->language = $language;
        $this->currency = $currency;
        $this->oLatitude = $oLat;
        $this->oLongitude = $oLng;
        $this->dLatitude = $dLat;
        $this->dLongitude = $dLng;
        $this->oName = $oName;
        $this->dName = $dName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getOName()
    {
        return $this->oName;
    }

    /**
     * @return string
     */
    public function getDName()
    {
        return $this->dName;
    }

    /**
     * @return string
     */
    public function getDPos()
    {
        return $this->dLatitude . ', ' . $this->dLongitude;
    }

    /**
     * @return string
     */
    public function getOPos()
    {
        return $this->oLatitude . ', ' . $this->oLongitude;
    }
}