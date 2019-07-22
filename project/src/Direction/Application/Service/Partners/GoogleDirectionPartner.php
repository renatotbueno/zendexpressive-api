<?php

namespace Direction\Application\Service\Partners;
use Direction\Domain\Entity\GoogleDirectionRequest;
use GuzzleHttp\Client;

/**
 * GoogleDirectionPartner
 */
class GoogleDirectionPartner
{

    public function __construct()
    {
    }

    public function getDirection(GoogleDirectionRequest $googleDirectionRequest)
    {
        try {

            $url = $googleDirectionRequest->getUrlQueryString();

            $client = new Client(['verify' => false ]);

            $response = $client->request('GET', $url);
            $response = json_decode($response->getBody()->getContents(), true);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return $response;
    }

}
