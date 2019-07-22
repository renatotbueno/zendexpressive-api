<?php

namespace Direction\Application\Service\Partners;

use Guzzle\Common\Exception\ExceptionCollection;
use GuzzleHttp\Client;
use Jettyn\Entity\UberEstimateRequest;

class Uber {

    private $estimate_endpoint = 'https://api.uber.com/v1.2/estimates/price';
    private $authorization = 'KA.eyJ2ZXJzaW9uIjoyLCJpZCI6IkROWTdqZkRiUSt1TnNoUXJ4eENqd1E9PSIsImV4cGlyZXNfYXQiOjE1MTg1NzE0NDcsInBpcGVsaW5lX2tleV9pZCI6Ik1RPT0iLCJwaXBlbGluZV9pZCI6MX0.meVLe5Xvid5ll7G1Aw8buxcCMZ1mDcTYYYkyZ-tKQFA';

    /**
     * @param UberEstimateRequest $request
     * @param bool $pure_return
     * @return array|null
     */
    public function searchEstimate(UberEstimateRequest $request, $pure_return = false)
    {
        try {

            $form = $this->getFormParams($request);
            $queryString = http_build_query($form);

            $urlAccess = $this->estimate_endpoint . '?' . $queryString;

            $client = new Client(['verify' => false ]);

            $response = $client->request('GET', $urlAccess, [
                'headers' => [
                    'Authorization' => $this->authorization,
                    'Accept-Language' => 'en_US'
                ]
            ]);

            $prices = [];
            if (!empty($response)) {

                $response = json_decode($response->getBody());

                $response = (array) $response;

                if ( $pure_return ) {

                    if ( isset($response['prices']) ) {
                        $prices = $response['prices'];
                    }
                }
            }

            return $prices;

        } catch (ExceptionCollection $GuzzleException) {
            dump($GuzzleException); die;
        } catch (\Exception $e) {
            dump($e); die;
        }

        return [];
    }

    public function getFormParams(UberEstimateRequest $request)
    {
        try {

            $params = [
                'start_latitude' => $request->getStartLatitude(),
                'start_longitude' => $request->getStartLongitude(),
                'end_latitude' => $request->getEndLatitude(),
                'end_longitude' => $request->getEndLongitude()
            ];

            return $params;

        } catch (\Exception $e) {
            dump($e); die;
        }
    }
}