<?php
namespace Cloudcogs\CounterPoint\Api\Response;

use Cloudcogs\CounterPoint\Api\Exception\CollectionDataKeyNotFound;

class Collection extends AbstractResponse
{
    public function getPayload($dataKey = null) : \ArrayIterator
    {
        $embedded = $this->offsetGet('_embedded');
        if ($dataKey != null)
        {
            if(isset($embedded->$dataKey))
            {
                return new \ArrayIterator($embedded->$dataKey, \ArrayIterator::ARRAY_AS_PROPS);
            }

            throw new CollectionDataKeyNotFound();
        }

        $embeddedObjects = [];
        foreach ((array) $embedded as $key=>$list)
        {
            $embeddedObjects[$key] = new \ArrayIterator($list,\ArrayIterator::ARRAY_AS_PROPS);
        }

        return new \ArrayIterator($embeddedObjects, \ArrayIterator::ARRAY_AS_PROPS);
    }
}