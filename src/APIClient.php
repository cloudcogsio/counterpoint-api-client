<?php
namespace Cloudcogs\CounterPoint;

use Cloudcogs\CounterPoint\Api\Customers;
use Cloudcogs\CounterPoint\Api\Items;
use Cloudcogs\CounterPoint\Api\Inventory;
use Cloudcogs\CounterPoint\Api\Categories;
use Cloudcogs\CounterPoint\Api\Subcategory;

/**
 * CounterPoint API Client Class
 *
 * @version 1.0
 * @author Ricardo Assing
 *
 * Used to create and return available API Objects that are then used to access the services within those APIs.
 *
 * @example
 * $config = new ArrayObject(['host' => 'HOST'], ArrayObject::ARRAY_AS_PROPS);
 *
 * $APIClient = new APIClient($config);
 * $API = $APIClient->Categories();
 * $categoryService = $API->category();
 * $response = $categoryService->fetchAll();
 */
class APIClient
{
    private $config;

    /**
     * @param \ArrayAccess $config
     *
     * $config = new \ArrayObject ([
     *     'host': "COUNTERPOINT API URL"
     * ]);
     *
     */
    public function __construct(\ArrayAccess $config)
    {
        $this->config = $config;
    }

    /**
     * Get client configuration
     *
     * @return \ArrayAccess
     */
    public function getConfig() : \ArrayAccess
    {
        return $this->config;
    }

    /**
     * Get Customer API object
     *
     * @return Customers
     */
    public function Customers() : Customers
    {
        return new Customers($this);
    }

    /**
     * Get Items API object
     *
     * @return Items
     */
    public function Items() : Items
    {
        return new Items($this);
    }

    /**
     * Get Inventory API object
     *
     * @return Inventory
     */
    public function Inventory() : Inventory
    {
        return new Inventory($this);
    }

    /**
     * Get Categories API object
     * @return Categories
     */
    public function Categories() : Categories
    {
        return new Categories($this);
    }

    /**
     * Get Subcategory API object
     * @return Subcategory
     */
    public function Subcategory() : Subcategory
    {
        return new Subcategory($this);
    }
}