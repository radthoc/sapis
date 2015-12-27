<?php
namespace AppBundle\Tests\Controller;

use GuzzleHttp\Client;
use AppBundle\Repository\ItemsRepository;
use AppBundle\Repository\CartRepository;
use Symfony\Component\HttpFoundation\Response;

class ShopControllerTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $baseURL = 'http://localhost/app_dev.php';
    
    public function setUp()
    {
        $this->markTestSkipped(
            'Enable this test in order to test your servers end point'
        );
        
        $this->client = new Client([
            'base_uri' => $this->baseURL,
            'http_errors' => false
        ]);
    }

    public function testItemsListAction()
    {
        $response = $this->client->request('GET', $this->baseURL . '/items/list');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('name', $data[0]);
    }

    public function testWrongMethod()
    {
        try {
            $response = $this->client->request('GET', '/items/save');
        } catch (Guzzle\Http\Exception\BadResponseException $e) {
            $this->assertEquals(Response::HTTP_BAD_REQUEST, $e->getResponse()->getStatusCode());
        }
    }
    
    public function testWrongAction()
    {
        try {
            $response = $this->client->request('POST', '/cart/save');
        } catch (Guzzle\Http\Exception\BadResponseException $e) {
            $this->assertEquals(Response::HTTP_BAD_REQUEST, $e->getResponse()->getStatusCode());
        }
    }
}
