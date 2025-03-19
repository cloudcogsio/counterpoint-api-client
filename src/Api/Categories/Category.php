<?php
namespace Cloudcogs\CounterPoint\Api\Categories;

use Cloudcogs\CounterPoint\Api\Service\AbstractService;
use Cloudcogs\CounterPoint\Http\Response;

/**
 * Category service
 *
 * Used to retrieve a list of all categories or a single category record
 */
class Category extends AbstractService
{
    /**
     * Retrieve a collection of all categories
     */
    public function fetchAll($filters = []) : Response
    {
        if (array_key_exists('page', $filters))
        {
            $this->HttpClient->addGetParam('page', ((intval($filters['page']) > 0) ? intval($filters['page']) : 1));
        }

        $this->HttpClient->setUri($this->host."/categories");
        return $this->HttpClient->get();
    }

    /**
     * Fetch a single category record by category id
     *
     * @param string $id
     * @return Response
     */
    public function get(string $id) : Response
    {
        $this->HttpClient->setUri($this->host."/categories/".$id);
        return $this->HttpClient->get();
    }
}