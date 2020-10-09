<?php
namespace Cloudcogs\CounterPoint\Api\Items;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Exception\FilterItemIdNotSpecified;

class Inventory extends AbstractService
{
    public function fetchAll($filters = []) : Response
    {
        //TODO - implement filters
        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0)?intval($filters['page']):1));
        }

        if (!array_key_exists('id', $filters))
            throw new FilterItemIdNotSpecified();

        $this->HttpClient->setUri($this->host."/items/".urlencode($filters['id'])."/inventory");
        return $this->HttpClient->get();
    }

    public function getLocationInventory($id, $location, $filters)
    {
        $this->HttpClient->setUri($this->host."/items/".urlencode($id)."/inventory/".urlencode($location));
        return $this->HttpClient->get();
    }
}