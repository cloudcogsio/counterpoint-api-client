<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Customers\Customer;
use Cloudcogs\CounterPoint\Api\Customers\Search;

class Customers extends AbstractApi
{
    public function customer()
    {
        return new Customer($this);
    }

    public function search($query,$filters = [])
    {
        $search = new Search($this);

        $filters['query'] = $query;

        return $search->fetchAll($filters);
    }
}