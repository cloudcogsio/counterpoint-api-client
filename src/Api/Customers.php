<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Customers\Customer;
use Cloudcogs\CounterPoint\Api\Customers\Search;
use Cloudcogs\CounterPoint\Api\Exception\SearchTermsNotDefined;
use Cloudcogs\CounterPoint\Http\Response;

class Customers extends AbstractApi
{
    public function customer(): Customer
    {
        return new Customer($this);
    }

    /**
     * @throws SearchTermsNotDefined
     */
    public function search($query, $filters = []): Response
    {
        $search = new Search($this);

        $filters['query'] = $query;

        return $search->fetchAll($filters);
    }
}