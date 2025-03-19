<?php
namespace Cloudcogs\CounterPoint\Api\Items;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;

class Item extends AbstractService
{
    public function fetchAll($filters = []) : Response
    {
        //TODO - implement filters
        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0) ? intval($filters['page']) : 1));
        }

        $this->HttpClient->setUri($this->host."/items");
        return $this->HttpClient->get();
    }

    public function get($id): Response
    {
        $this->HttpClient->setUri($this->host."/items/".$id);
        return $this->HttpClient->get();
    }
}