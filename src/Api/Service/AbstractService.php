<?php
namespace Cloudcogs\CounterPoint\Api\Service;

use Cloudcogs\CounterPoint\Http\Client;
use Cloudcogs\CounterPoint\Api\AbstractApi;
use Cloudcogs\CounterPoint\Api\Exception\InvalidLink;
use Cloudcogs\CounterPoint\Http\Response;

abstract  class AbstractService
{
    protected int $page_size;
    protected Client $HttpClient;
    protected AbstractApi $ApiClass;

    protected string $host;

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
     * @param int $records
     * @return AbstractService
     */
    public function setPageSize(int $records = 25): static
    {
        $this->page_size = $records;
        $this->HttpClient->addGetParam('records', $this->page_size);

        return $this;
    }

    public function getPageSize(): int
    {
        return $this->page_size;
    }

    public function HTTPClientProxy(): Client
    {
        return $this->HttpClient;
    }

    /**
     * Convenience method used to make a service call from a link object
     *
     * @param array $link
     * @param boolean $newHTTPClient
     * @return Response
     *@throws InvalidLink
     */
    public function followLink(array $link, bool $newHTTPClient = true): Response
    {
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