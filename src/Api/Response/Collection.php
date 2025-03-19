<?php
namespace Cloudcogs\CounterPoint\Api\Response;

use Cloudcogs\CounterPoint\Api\Exception\CollectionDataKeyNotFound;

class Collection extends AbstractResponse
{
    /**
     * @throws CollectionDataKeyNotFound
     */
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

        $embeddedObjects = array_map(function ($list) {
            return new \ArrayIterator($list, \ArrayIterator::ARRAY_AS_PROPS);
        }, (array) $embedded);

        return new \ArrayIterator($embeddedObjects, \ArrayIterator::ARRAY_AS_PROPS);
    }
}