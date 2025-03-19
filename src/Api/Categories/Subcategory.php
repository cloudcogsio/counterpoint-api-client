<?php
namespace Cloudcogs\CounterPoint\Api\Categories;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Exception\FilterCategoryIdNotSpecified;

class Subcategory extends AbstractService
{
    /**
     * @throws FilterCategoryIdNotSpecified
     */
    public function fetchAll($filters = []) : Response
    {
        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0) ? intval($filters['page']) : 1));
        }

        if (!array_key_exists('id', $filters))
            throw new FilterCategoryIdNotSpecified();

        $this->HttpClient->setUri($this->host."/categories/".urlencode($filters['id'])."/subcategory");
        return $this->HttpClient->get();
    }
}