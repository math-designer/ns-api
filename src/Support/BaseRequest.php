<?php

namespace NS\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

abstract class BaseRequest
{
    protected $clientHttp;
    protected $baseUrl;
    protected $token = 'MEU_TOKEN';
    protected $defaultOptions = [
        'verify' => false
    ];

    public function __construct()
    {
        $this->defaultOptions = array_merge($this->defaultOptions, ['base_uri' => $this->baseUrl]);
        $this->clientHttp = new Client($this->defaultOptions);
    }

    protected function sendRequest($method = 'get', $endpoint, $data)
    {
        $data['X-AUTH-TOKEN'] = $this->token;
        $_data = ['json' => $data];

        try {
            $response = $this->clientHttp->request($method, $endpoint, $_data);
            return $this->parseResponse($response);
        } catch (ClientException $e) {
            return $this->parseResponse($e->getResponse());
        } catch (ServerException $e) {
            return $this->parseResponse($e->getResponse());
        }
    }

    protected function parseResponse($response)
    {
        $content = $response->getBody()->getContents();
        return \GuzzleHttp\json_decode($content, true);
    }
}