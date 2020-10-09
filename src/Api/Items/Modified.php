<?php
namespace Cloudcogs\CounterPoint\Api\Items;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Exception\FilterSinceNotDefined;

class Modified extends AbstractService
{
    public function fetchAll($filters = []) : Response
    {
        if (!array_key_exists('since', $filters))
            throw new FilterSinceNotDefined();

        $query = $filters['since'];

        $uri = "/items/modified/";

        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0)?intval($filters['page']):1));
        }

        $this->HttpClient->setUri($this->host.$uri.urlencode($query));
        return $this->HttpClient->get();
    }
}