<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Inventory\Modified;

class Inventory extends AbstractApi
{
    public function inventory($id,$filters = [])
    {
        $items = new Items($this->getClient());
        return $items->inventory($id, $filters);
    }

    public function modified($since,$filters = [])
    {
        $modified = new Modified($this);

        $filters['since'] = $since;

        return $modified->fetchAll($filters);
    }
}