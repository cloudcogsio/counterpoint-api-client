<?php
namespace Cloudcogs\CounterPoint\Api\Categories;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Exception\SearchTermsNotDefined;

class Search extends AbstractService
{
    public function fetchAll($filters = []) : Response
    {
        if (!array_key_exists('query', $filters))
            throw new SearchTermsNotDefined();

        $query = $filters['query'];

        $uri = "/categories/search/";

        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0)?intval($filters['page']):1));
        }

        $this->HttpClient->setUri($this->host.$uri.urlencode($query));
        return $this->HttpClient->get();
    }
}