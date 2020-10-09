<?php
namespace Cloudcogs\CounterPoint\Api\Customers;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;

class Customer extends AbstractService
{
    public function fetchAll($filters = []) : Response
    {
        //TODO - implement filters
        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0)?intval($filters['page']):1));
        }

        $this->HttpClient->setUri($this->host."/customers");
        return $this->HttpClient->get();
    }

    public function get($id)
    {
        $this->HttpClient->setUri($this->host."/customers/".$id);
        return $this->HttpClient->get();
    }
}