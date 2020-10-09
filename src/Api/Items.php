<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Items\Item;
use Cloudcogs\CounterPoint\Api\Items\Search;
use Cloudcogs\CounterPoint\Api\Items\Modified;
use Cloudcogs\CounterPoint\Api\Items\Inventory as InventorySvc;

class Items extends AbstractApi
{
    public function item()
    {
        return new Item($this);
    }

    public function search($query,$filters = [])
    {
        $search = new Search($this);

        $filters['query'] = $query;

        return $search->fetchAll($filters);
    }

    public function modified($since,$filters = [])
    {
        $modified = new Modified($this);

        $filters['since'] = $since;

        return $modified->fetchAll($filters);
    }

    public function inventory($id,$filters = [])
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