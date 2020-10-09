<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Categories\Category;
use Cloudcogs\CounterPoint\Api\Categories\Search;
use Cloudcogs\CounterPoint\Api\Categories\Subcategory as SubcategorySvc;
use Cloudcogs\CounterPoint\Http\Response;

class Categories extends AbstractApi
{
    public function category() : Category
    {
        return new Category($this);
    }

    public function search($query,$filters = []) : Response
    {
        $search = new Search($this);

        $filters['query'] = $query;

        return $search->fetchAll($filters);
    }

    public function subcategory($id,$filters = []) : Response
    {
        $subcategoryApi = new Subcategory($this->getClient());
        $subcategorySvc = new SubcategorySvc($subcategoryApi);

        $filters['id'] = $id;
        return $subcategorySvc->fetchAll($filters);
    }
}