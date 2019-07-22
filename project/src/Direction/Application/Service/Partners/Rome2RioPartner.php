<?php

namespace Direction\Application\Service\Partners;

use GuzzleHttp\Client;
use Direction\Domain\Entity\Rome2RioRequest;

class Rome2RioPartner
{

//    private $endPoint = 'https://rome2rio12.p.mashape.com/Search';
//    private $apiKey = 'qaO2t9Uo84mshYwfO6kQvCOPRzb9p1N4MiCjsnjkFuaLix1NUj'; //heade X-Mashape-Key
    private $endPoint = 'http://free.rome2rio.com/api/1.4/json/Search';
    private $apikey = 'wEf7w8TQ';

    //$url = 'https://rome2rio12.p.mashape.com/Search?currency=EUR&dPos=41.3887900%2C2.1589900&oKind=City&oPos=40.4165000%2C-3.7025600';

    /**
     * @param Rome2RioRequest $request
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(Rome2RioRequest $request)
    {
        $response = null;

        try {

            $form = $this->getFormParams($request);
            $queryString = http_build_query($form);

            $urlAccess = $this->endPoint . '?' . $queryString;

            $client = new Client(['verify' => false, 'connect_timeout' => 30]);

            $response = $client->request('GET', $urlAccess);

        } catch (\Exception $e) {
            dd($e);
        }

        return $response;
    }

    public function objectToArray($obj)
    {
        if ( $obj ) {
            array_walk_recursive($obj, function(&$item, $key){

                $item = (array) $item;
            });
        }

        return $obj;
    }

    public function getFormParams(Rome2RioRequest $request)
    {
        try {

            $params = [
                'key' => $this->apikey,
                'language' => $request->getLanguage(),
                'currency' => $request->getCurrency()
            ];

            if (null != $request->getOPos()) {
                $params['oPos'] = $request->getOPos();
            }

            if (null != $request->getDPos()) {
                $params['dPos'] = $request->getDPos();
            }

            if (null != $request->getOName()) {
                $params['oName'] = $request->getOName();
            }

            if (null != $request->getDName()) {
                $params['dName'] = $request->getDName();
            }

            return $params;

        } catch (\Exception $e) {
            dd($e);
        }
    }
}
