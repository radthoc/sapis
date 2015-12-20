<?php
namespace App\Tests\Controller;

use GuzzleHttp\Client;
use Mockery;
use App\Repository\ItemsRepository;
use App\Repository\CartRepository;

class TestShopController extends \PHPUnit_Framework_TestCase
{
    private $DBHandler;
    private $itemsRepository;
    private $cartRepository;

    public function setUp()
    {        
        //$this->DBHandler = Mockery::mock('AppBundle\Services\DBHandler');

        //$this->itemsRepository = new ItemsRepository($this->DBHandler);
        //$this->cartRepository = new CartRepository($this->DBHandler);
    }

    public function testItemsListAction()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost/items/list');
        
        /*$client = new Client(
            ['base_uri' => 'http://localhost'],
            array(
                'request.options' => array(
                    'exceptions' => false,
                )
            ));
        */

        echo $response->getStatusCode();
        echo var_export($response->getHeader('content-type'), true);
        echo $response->getBody();


        $this->assertEquals(200, $response->getStatusCode());

        //$data = json_decode($response->getBody(true), true);
        //$this->assertArrayHasKey('topic', $data);
    }

    /*
    public function testGetTopicActionNotFound()
    {
        $client = new Client(
            ['base_uri' => 'http://localhost:8083'],
            array(
                'request.options' => array(
                    'exceptions' => false,
                )
            ));

        $params = '{"topicID":25}';

        try {
            $request = $client->post('/get/topics', [
                'body' => $params,
                'Content-Type' => 'application/json'
            ]);
            $response = $request->send();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->assertEquals(404, $e->getResponse()->getStatusCode());
        }
    }
    */
}
