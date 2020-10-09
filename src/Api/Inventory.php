<?php
namespace Cloudcogs\CounterPoint\Api;

class Inventory extends AbstractApi
{
    public function inventory($id,$filters = [])
    {
        $items = new Items($this->getClient());
        return $items->inventory($id, $filters);
    }
}