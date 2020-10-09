<?php
/**
 * Example retrieving a collection of categories
 */

use Cloudcogs\CounterPoint\APIClient;
use Cloudcogs\CounterPoint\Http\Response;
use Cloudcogs\CounterPoint\Api\Response\Collection;

require '../vendor/autoload.php';

$config = new ArrayObject(['host' => 'http://localhost:8080'], ArrayObject::ARRAY_AS_PROPS);

$client = new APIClient($config);
$APIClass = $client->Categories();
$service = $APIClass->category();

/** @var  Response $response **/
$response = $service->setPageSize(5)->fetchAll();

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
     * @var \Cloudcogs\CounterPoint\Api\Response\Links $collectionLinks
     */
    $collectionLinks = $collection->links();

    print "Currentpage: ".$collectionLinks->self->href."\n";
    print "Firstpage: ".$collectionLinks->first->href."\n";
    print "Lastpage: ".$collectionLinks->last->href."\n";
    print "Next: ".$collectionLinks->next->href."\n";

    /**
     * Get the dataset from the collection
     * @var ArrayIterator $items
     */
    $items = $collection->getPayload('category');

    $firstItem = $items->current();

    print "First item DESCR: ".$firstItem->DESCR."\n";

    $firstItemLinks = $firstItem->links();
    $subcategoryLink = $firstItemLinks->subcategories;

    // This is a second API service call using "followLink" to get the subcategories for the first category
    print "Fetching subcategories for ".$firstItem->CATEG_COD."\n";
    $firstItemSubcategoryResponse = $service->followLink($subcategoryLink, false);

    if($firstItemSubcategoryResponse->isSuccess())
    {
        print "Category '".$firstItem->CATEG_COD."' has ".$firstItemSubcategoryResponse->getApiResponse()->total_items." subcategories";
    }
}
