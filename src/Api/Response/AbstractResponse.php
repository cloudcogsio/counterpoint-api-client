<?php
namespace Cloudcogs\CounterPoint\Api\Response;

abstract class AbstractResponse extends \ArrayObject
{
    public function links()
    {
        $links = $this->offsetGet('_links');
        if (!($links instanceof Links))
        {
            return new Links((array) $this->offsetGet('_links'),\ArrayObject::ARRAY_AS_PROPS);
        }

        return $links;
    }
}