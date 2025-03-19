<?php
namespace Cloudcogs\CounterPoint\Api\Inventory;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Exception\FilterSinceNotDefined;
use Cloudcogs\CounterPoint\Api\Exception\InventoryLocationNotSpecified;

class Modified extends AbstractService
{
    /**
     * @throws FilterSinceNotDefined
     * @throws InventoryLocationNotSpecified
     */
    public function fetchAll($filters = []) : Response
    {
        if (!array_key_exists('since', $filters))
            throw new FilterSinceNotDefined();

        if (!array_key_exists('location', $filters))
            throw new InventoryLocationNotSpecified();

        $query = $filters['since'];
        $location = $filters['location'];

        if (is_array($location))
        {
            $location = implode(",", $location);
        }

        $uri = "/inventory/modified/".$location."/";

        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0) ? intval($filters['page']) : 1));
        }

        $this->HttpClient->setUri($this->host.$uri.urlencode($query));
        return $this->HttpClient->get();
    }
}