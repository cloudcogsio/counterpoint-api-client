<?php
namespace Cloudcogs\CounterPoint\Api;

use Cloudcogs\CounterPoint\Api\Exception\FilterCategoryIdNotSpecified;
use Cloudcogs\CounterPoint\Http\Response;

class Subcategory extends AbstractApi
{
    /**
     * @throws FilterCategoryIdNotSpecified
     */
    public function subcategory($id, $filters = []): Response
    {
        $categories = new Categories($this->getClient());
        return $categories->subcategory($id, $filters);
    }
}