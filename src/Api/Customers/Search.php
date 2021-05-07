<?php
namespace Cloudcogs\CounterPoint\Api\Customers;

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

        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0)?intval($filters['page']):1));
        }

        if (is_array($query))
        {
            foreach ($query as $param=>$value)
            {
                $this->HttpClient->addGetParam($param, $value);
            }

            $this->HttpClient->setUri($this->host."/customers/search");
        }
        else
        {
            $this->HttpClient->setUri($this->host."/customers/search/".urlencode($query));
        }

        return $this->HttpClient->get();
    }
}