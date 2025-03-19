<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Exception\FilterSinceNotDefined;
use Cloudcogs\CounterPoint\Api\Exception\InventoryLocationNotSpecified;
use Cloudcogs\CounterPoint\Api\Inventory\Modified;
use Cloudcogs\CounterPoint\Http\Response;

class Inventory extends AbstractApi
{
    public function inventory($id,$filters = []): Response
    {
        $items = new Items($this->getClient());
        return $items->inventory($id, $filters);
    }

    /**
     * @throws FilterSinceNotDefined
     * @throws InventoryLocationNotSpecified
     */
    public function modified($since, $filters = []): Response
    {
        $modified = new Modified($this);

        $filters['since'] = $since;

        return $modified->fetchAll($filters);
    }
}