<?php
namespace Cloudcogs\CounterPoint\Api\Items;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Exception\SearchTermsNotDefined;
use Cloudcogs\CounterPoint\Api\Exception\FilterInvalidItemStatus;

class Search extends AbstractService
{
    /**
     * @throws FilterInvalidItemStatus
     * @throws SearchTermsNotDefined
     */
    public function fetchAll($filters = []) : Response
    {
        if (!array_key_exists('query', $filters))
            throw new SearchTermsNotDefined();

        $query = $filters['query'];

        $uri = "/items";

        if (array_key_exists('status', $filters))
        {
            $status = strtolower($filters['status']);
            if (!in_array($status, ['active','inactive']))
                throw new FilterInvalidItemStatus();

            $uri .= "/$status";
        }

        $uri .= "/search/";

        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0) ? intval($filters['page']) : 1));
        }

        $this->HttpClient->setUri($this->host.$uri.urlencode($query));
        return $this->HttpClient->get();
    }
}