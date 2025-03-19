<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Exception\FilterInvalidItemStatus;
use Cloudcogs\CounterPoint\Api\Exception\FilterItemIdNotSpecified;
use Cloudcogs\CounterPoint\Api\Exception\FilterSinceNotDefined;
use Cloudcogs\CounterPoint\Api\Exception\SearchTermsNotDefined;
use Cloudcogs\CounterPoint\Api\Items\Item;
use Cloudcogs\CounterPoint\Api\Items\Search;
use Cloudcogs\CounterPoint\Api\Items\Modified;
use Cloudcogs\CounterPoint\Api\Items\Inventory as InventorySvc;
use Cloudcogs\CounterPoint\Http\Response;

class Items extends AbstractApi
{
    public function item(): Item
    {
        return new Item($this);
    }

    /**
     * @throws FilterInvalidItemStatus
     * @throws SearchTermsNotDefined
     */
    public function search($query, $filters = []): Response
    {
        $search = new Search($this);

        $filters['query'] = $query;

        return $search->fetchAll($filters);
    }

    /**
     * @throws FilterSinceNotDefined
     */
    public function modified($since, $filters = []): Response
    {
        $modified = new Modified($this);

        $filters['since'] = $since;

        return $modified->fetchAll($filters);
    }

    /**
     * @throws FilterItemIdNotSpecified
     */
    public function inventory($id, $filters = []): Response
    {
        $inventoryApi = new Inventory($this->getClient());

        $inventorySvc = new InventorySvc($inventoryApi);

        if (array_key_exists("location", $filters))
        {
            return $inventorySvc->getLocationInventory($id, $filters['location'], $filters);
        }
        else
        {
            $filters['id'] = $id;
            return $inventorySvc->fetchAll($filters);
        }
    }
}