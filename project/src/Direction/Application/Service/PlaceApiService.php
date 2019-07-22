<?php

declare(strict_types=1);

namespace Direction\Application\Service;

use GuzzleHttp\Client;

final class PlaceApiService
{

    private $config;

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * RouterService constructor.
     * @param $config
     */
    public function __construct(
        $config
    )
    {
        $this->config = $config;
        $this->guzzleClient = new Client();
    }

    /**
     * @param $cityId
     * @return null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCityById($cityId)
    {
        $endpoint = $this->config->place_api_service['host'] . $this->config->place_api_service['endpoint_get_city'];
        $endpoint = str_replace('{city_id}', $cityId, $endpoint);

        $response = $this->guzzleClient->request(
            'GET',
            $endpoint
        );

        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }

    /**
     * @param $latitude
     * @param $longitude
     * @param string $locale
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCityByGeocoding($latitude, $longitude, $locale = 'en')
    {
        $endpoint = $this->config->place_api_service['host'] . $this->config->place_api_service['endpoint_city_by_geocoding'];
        $endpoint = str_replace('{latitude}', $latitude, $endpoint);
        $endpoint = str_replace('{longitude}', $longitude, $endpoint);
        $endpoint = str_replace('{locale}', $locale, $endpoint);

        $response = $this->guzzleClient->request(
            'GET',
            $endpoint
        );

        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}
