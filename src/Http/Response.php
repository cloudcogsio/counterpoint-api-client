<?php
namespace Cloudcogs\CounterPoint\Http;

use Cloudcogs\CounterPoint\Api\Exception\ContentTypeMissingException;
use Cloudcogs\CounterPoint\Api\Response\Collection;
use Cloudcogs\CounterPoint\Api\Response\Entity;
use Cloudcogs\CounterPoint\Api\AbstractApi;
use Cloudcogs\CounterPoint\Api\Response\Links;

class Response
{
    private $response;
    protected $dataObject;
    protected $apiResponse;
    protected $apiClass;
    protected $entityName;

    public function __construct(\Laminas\Http\Response $response, AbstractApi $apiClass)
    {
        $this->response = $response;
        $this->apiClass = $apiClass;
        $this->entityName = get_class($apiClass)."\\Entity";
    }

    /**
     * Proxy to underlying \Laminas\Http\Response object
     *
     * @return Response
     */
    public function proxy() : \Laminas\Http\Response
    {
        return $this->response;
    }

    /**
     * Get PHP representation of returned JSON data
     *
     * @return mixed
     */
    public function getDataObject()
    {
        return $this->dataObject;
    }

    /**
     * Get response collection or entity
     *
     * @return \Cloudcogs\CounterPoint\Api\Response\Collection|\Cloudcogs\CounterPoint\Api\Response\Entity
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Evaluates JSON data returned from the CounterPoint API service call and sets the appropriate response for retrieval by calling the "getApiResponse" method of this class.
     *
     * @throws \Cloudcogs\CounterPoint\Api\Exception\ContentTypeMissingException
     * @return Response
     */
    public function evaluate() : Response
    {
        $responseHeaders = $this->response->getHeaders();
        if(!$responseHeaders->has('Content-Type'))
        {
            $UnknownContentTypeException = new ContentTypeMissingException('Response has no "Content-Type" header');
            throw $UnknownContentTypeException;
        }

        $contentType = $responseHeaders->get('Content-Type')->getFieldValue();
        switch ($contentType)
        {
            case "application/hal+json":
                $this->dataObject = json_decode($this->response->getBody());

                if (isset($this->dataObject->page_size))
                {
                    $embedded = (array) $this->dataObject->_embedded;
                    foreach ($embedded as $key=>$itemList)
                    {
                        foreach ($itemList as $idx=>$item)
                        {
                            $item = (array) $item;
                            $item['_links'] = new Links((array) $item['_links'], \ArrayObject::ARRAY_AS_PROPS);
                            $embedded[$key][$idx] = new $this->entityName($item, \ArrayObject::ARRAY_AS_PROPS);
                        }
                    }

                    $this->dataObject->_embedded = (object) $embedded;
                    $this->dataObject->_links = new Links((array) $this->dataObject->_links, \ArrayObject::ARRAY_AS_PROPS);

                    $this->apiResponse = new Collection($this->dataObject,\ArrayObject::ARRAY_AS_PROPS);
                }
                else
                {
                    $data = (array) $this->dataObject;
                    $data['_links'] = new Links((array) $data['_links'],\ArrayObject::ARRAY_AS_PROPS);

                    $entity = new $this->entityName($data,\ArrayObject::ARRAY_AS_PROPS);

                    $this->apiResponse = $entity;
                }
                break;

            default:
                $UnknownContentTypeException = new ContentTypeMissingException("Content-Type: $contentType");
                throw $UnknownContentTypeException;
                break;
        }

        return $this;
    }

    public function __call($name, $args)
    {
        return call_user_func_array([$this->response,$name], $args);
    }
}