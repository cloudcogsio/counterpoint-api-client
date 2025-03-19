<?php
namespace Cloudcogs\CounterPoint\Http;

use Cloudcogs\CounterPoint\Api\Exception\ContentTypeMissingException;
use Cloudcogs\CounterPoint\Api\Exception\ContentTypeUnknownException;
use Laminas\Http\Request;
use Cloudcogs\CounterPoint\Api\AbstractApi;

class Client extends \Laminas\Http\Client
{
    protected array $headers;
    protected array $apiGetParams;
    protected array $apiPostParams;
    protected AbstractApi $apiClass;

    public function __construct($uri = null, $options = null)
    {
        parent::__construct($uri, $options);

        $this->headers['Accept'] = '*/*';

        $this->apiGetParams = [];
        $this->apiPostParams = [];
    }

    public function setApiClass(AbstractApi $apiClass) : Client
    {
        $this->apiClass = $apiClass;
        return $this;
    }

    public function addGetParam($name,$value) : Client
    {
        $this->apiGetParams[$name] = $value;

        return $this;
    }

    public function addPostParam($name,$value) : Client
    {
        $this->apiPostParams[$name] = $value;

        return $this;
    }

    public function get() : Response
    {
        $this->setMethod(Request::METHOD_GET);

        return $this->sendRequest();
    }

    public function patch() : Response
    {
        $this->setMethod(Request::METHOD_PATCH);

        return $this->sendRequest();
    }

    /**
     * @throws ContentTypeMissingException
     * @throws ContentTypeUnknownException
     */
    public function sendRequest() : Response
    {
        if (!$this->hasHeader('Accept'))
        {
            $this->setHeaders($this->headers);
        }
        $this->setParameterGet($this->apiGetParams);
        $this->setParameterPost($this->apiPostParams);

        $response = $this->send();

        $ApiResponse = new Response($response,$this->apiClass);

        return $ApiResponse->evaluate();
    }
}