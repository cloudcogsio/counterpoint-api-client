<?php
namespace Cloudcogs\CounterPoint\Api\Service;

use Cloudcogs\CounterPoint\Http\Client;
use Cloudcogs\CounterPoint\Api\AbstractApi;
use Cloudcogs\CounterPoint\Api\Exception\InvalidLink;

abstract  class AbstractService
{
    protected $page_size;
    protected $HttpClient;
    protected $ApiClass;

    protected $host;

    abstract function fetchAll($filters = []);

    public function __construct(AbstractApi $APIClass)
    {
        $this->ApiClass = $APIClass;
        $this->HttpClient = new Client();
        $this->HttpClient->setApiClass($APIClass);
        $this->host = $this->ApiClass->getClient()->getConfig()->host;
    }

    /**
     * Set desired page size for collections
     *
     * @param number $records
     * @return \Cloudcogs\CounterPoint\Api\Service\AbstractService
     */
    public function setPageSize($records = 25)
    {
        $this->page_size = intval($records);
        $this->HttpClient->addGetParam('records', $this->page_size);

        return $this;
    }

    public function getPageSize()
    {
        return $this->page_size;
    }

    public function HTTPClientProxy()
    {
        return $this->HttpClient;
    }

    /**
     * Convenience method used to make a service call from a link object
     *
     * @param \ArrayObject $link
     * @param boolean $newHTTPClient
     * @throws InvalidLink
     * @return \Cloudcogs\CounterPoint\Http\Response
     */
    public function followLink($link, $newHTTPClient = true)
    {
        $link = (array) $link;

        if (!array_key_exists("href", $link)) throw new InvalidLink();

        if ($newHTTPClient)
        {
            $this->HttpClient = new Client();
            $this->HttpClient->setApiClass($this->ApiClass);
        }

        $this->HttpClient->setUri($link['href']);

        return $this->HttpClient->get();
    }
}