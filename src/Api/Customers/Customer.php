<?php
namespace Cloudcogs\CounterPoint\Api\Customers;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Laminas\Http\Request;

class Customer extends AbstractService
{
    public function fetchAll($filters = []) : Response
    {
        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0) ? intval($filters['page']):1));
        }

        // Apply Filters as GET params
        foreach ($filters as $param=>$value)
        {
            $this->HttpClient->addGetParam($param, $value);
        }

        $this
			->HttpClient
			->setUri($this->host."/customers");

        return $this->HttpClient->get();
    }

    public function get($id): Response
    {
        $this->HttpClient->setUri($this->host."/customers/".$id);
        return $this->HttpClient->get();
    }

    public function patch($id, $data): \Laminas\Http\Response
    {
        return $this->HttpClient
			->setUri($this->host."/customers/".$id)
			->setRawBody(json_encode((object) $data))
			->setHeaders([
				'Accept'=>"*/*",
				'Content-Type'=>"application/json"
			])
			->setMethod(Request::METHOD_PATCH)
			->send();
    }

    public function patchList(array $list): Response
    {
        return $this->HttpClient
            ->setUri($this->host."/customers")
            ->setRawBody(json_encode($list))
            ->setHeaders([
                'Accept'=>"*/*",
                'Content-Type'=>"application/json"
            ])
            ->patch();
    }
}