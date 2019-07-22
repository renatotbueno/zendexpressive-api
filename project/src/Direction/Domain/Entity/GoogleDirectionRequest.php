<?php

namespace Direction\Domain\Entity;

/**
 * GoogleDirectionRequest
 */
class GoogleDirectionRequest
{
//	const _GOOGLE_API_KEY_ = 'AIzaSyCqf6FdQHGdCUoMrdovaKMc2W0hsU8GS18';

    /**
     * API KEY usando o email jettyn.api@gmail.com
     */
    const _GOOGLE_API_KEY_ = 'AIzaSyAHQY27KETBY3BXivLCPCckX2gzzwnOn00';
    const _GOOGLE_API_URL_ = 'https://maps.googleapis.com/maps/api/directions/json?';

    const _GOOGLE_MODE_TRANSIT_ = 'transit';
    const _GOOGLE_MODE_DRIVE_ = 'drive';
    const _GOOGLE_MODE_WALKING_ = 'walking';

    private $fromLat;
    private $fromLng;
    private $toLat;
    private $toLng;
    private $departureTime;
    private $mode;
    private $alternatives;
    private $language;

    public function __construct(
        $fromLat, $fromLng,
        $toLat, $toLng,
        $mode,
        $language,
        $departureTime,
        $alternatives = 'true'
    )
    {

        $this->fromLat = $fromLat;
        $this->fromLng = $fromLng;
        $this->toLat = $toLat;
        $this->toLng = $toLng;
        $this->departureTime = $departureTime;
        $this->mode = $mode;
        $this->alternatives = $alternatives;
        $this->language = $language;

    }

    public function getUrlQueryString() {

        $mode = $this->getMode();
        $language = $this->getLanguage();
        $latLngSaida = $this->getFromPosition();
        $latLngDestino = $this->getToPosition();
        $alternatives = $this->getAlternatives();

        $params = "mode=$mode";
        $params .= "&origin=$latLngSaida";
        $params .= "&destination=$latLngDestino";
        $params .= "&alternatives=$alternatives";
        $params .= "&language=$language";
        $params .= "&key=".$this->getGoogleApiKey();

        if ($this->getDepartureTime() != null) {
            $params .= "&departure_time=" . $this->getDepartureTime();
        }

        return $this->getGoogleApiUrl() . $params;
    }

    /**
     * @return int
     */
    public function getAlternatives()
    {
        return $this->alternatives;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return mixed
     */
    public function getFromPosition()
    {
        return $this->fromLat . ',' . $this->fromLng;
    }

    /**
     * @return mixed
     */
    public function getToPosition()
    {
        return $this->toLat . ',' . $this->toLng;
    }

    /**
     * @return mixed
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * @return string _GOOGLE_MODE_TRANSIT_
     * Retorna o modo transit do google directions
     */
    public function getModeTransit()
    {
        return self::_GOOGLE_MODE_TRANSIT_;
    }

    /**
     * @return string _GOOGLE_MODE_WALKING__
     * Retorna o modo walking do google directions
     */
    public function getModeWalking()
    {
        return self::_GOOGLE_MODE_WALKING_;
    }

    /**
     * @return string GOOGLE API KEY
     */
    public function getGoogleApiKey()
    {
        return self::_GOOGLE_API_KEY_;
    }

    /**
     * @return string GOOGLE API URL
     */
    public function getGoogleApiUrl()
    {
        return self::_GOOGLE_API_URL_;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getModeDrive()
    {
        return self::_GOOGLE_MODE_DRIVE_;
    }

}
