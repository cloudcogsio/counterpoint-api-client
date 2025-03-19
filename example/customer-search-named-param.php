<?php
/**
 * Example retrieving (a) customer(s) by email
 *
 * Allowed named params are:
 * NAM, EMAIL_ADRS_1
 *
 * For partial search by name, pass a search string to the `search` method
 */

use Cloudcogs\CounterPoint\Api\Response\Links;
use Cloudcogs\CounterPoint\APIClient;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Response\Collection;

require '../vendor/autoload.php';

$config = new ArrayObject(['host' => 'http://localhost:8080'], ArrayObject::ARRAY_AS_PROPS);

$client = new APIClient($config);
$APIClass = $client->Customers();

/*
 * search($query)
 *
 * $query can be:
 * string - partial search by customer name
 * array[NAM=?, EMAIL_ADRS_1=?] - partial seach by each specified param
 */
$response = $APIClass->search(['EMAIL_ADRS_1'=>$argv[1]]);

if ($response->isSuccess())
{
    /**
     * Get response collection object
     * @var Collection $collection
     */
    $collection = $response->getApiResponse();

    print "# of result pages: ".$collection->page_count."\n";
    print "Page size: ".$collection->page_size."\n";
    print "Total items (result set): ".$collection->total_items."\n";
    print "Current page: ".$collection->page."\n";

    /**
     * Get the links from the collection
     *
     * @var Links $collectionLinks
     */
    $collectionLinks = $collection->links();

    print "Currentpage: ".$collectionLinks->self->href."\n";
    print "Firstpage: ".$collectionLinks->first->href."\n";
    print "Lastpage: ".$collectionLinks->last->href."\n";
    print "Next: ".@$collectionLinks->next->href."\n";

    /**
     * Get the dataset from the collection
     */
    $items = $collection->getPayload('items');

    $firstItem = $items->current();

    print "First Customer NAME: ".$firstItem->NAM."\n";

    $firstItemLinks = $firstItem->links();
}
