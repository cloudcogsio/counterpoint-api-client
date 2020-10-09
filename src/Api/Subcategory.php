<?php
namespace Cloudcogs\CounterPoint\Api;

class Subcategory extends AbstractApi
{
    public function subcategory($id,$filters = [])
    {
        $categories = new Categories($this->getClient());
        return $categories->subcategory($id, $filters);
    }
}