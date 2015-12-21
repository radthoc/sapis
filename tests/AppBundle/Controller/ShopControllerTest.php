<?php
namespace App\Tests\Controller;

use GuzzleHttp\Client;
use Mockery;
use App\Repository\ItemsRepository;
use App\Repository\CartRepository;

class ShopControllerTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost/app_dev.php',
            'http_errors' => false
        ]);
    }

    public function testItemsListAction()
    {
        $response = $this->client->request('GET', 'http://localhost/app_dev.php/items/list');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('name', $data[0]);
    }

    public function testWrongMethod()
    {
        try {
            $response = $this->client->request('GET', '/items/save');
        } catch (Guzzle\Http\Exception\BadResponseException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }
    
    public function testWrongAction()
    {
        try {
            $response = $this->client->request('POST', '/cart/save');
        } catch (Guzzle\Http\Exception\BadResponseException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
        }
    }
}
