<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\APIClient;

abstract class AbstractApi
{
    private $APIClient;

    public function __construct(APIClient $client)
    {
        $this->APIClient = $client;
    }

    public function getClient()
    {
        return $this->APIClient;
    }
}