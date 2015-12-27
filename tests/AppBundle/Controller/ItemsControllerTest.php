<?php
namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Mockery;

class ItemsControllerTest extends WebTestCase
{
    private $client;
    private $dbHandler;
    
    public function setUp(){
        $this->dbHandler = Mockery::mock('AppBundle\Service\DBHandler');
    }
    
    public function testListItemsOK()
    {
        $this->client = static::createClient();
        
        $crawler = $this->client->request('GET', '/items/list');

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        
        $this->assertEquals(
            Response::HTTP_OK, 
            $this->client->getResponse()->getStatusCode()
        );
    }
    
    public function testSaveItem()
    {
        $this->client = static::createClient([], [
            'HTTP_METHOD' => 'POST'
        ]);
        
        $item = [
            'name' => 'item 4',
            'description' => 'lorem ipsum... ',
            'price' => 23.60
        ];
        
        $this->dbHandler->shouldReceive('persist')
            ->once()
            ->with(
                'items',
                $item
            )
            ->andReturn(40);

        
        $crawler = $this->client->request(
            'POST',
            '/items/save',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"name":"item 13","description":"lorem ipsum... ","price":"11.41"}'
        );
        
        $this->assertEquals(
            Response::HTTP_OK, 
            $this->client->getResponse()->getStatusCode()
        );
    }
    
    public function testSaveItemWithId()
    {
        $item = [
            'name' => 'item 13',
            'description' => 'lorem ipsum... ',
            'price' => 11.41,
            'id' => 30
        ];
        
        $this->dbHandler->shouldReceive('persist')
            ->once()
            ->with(
                'items',
                [
                    'name' => 'item 13',
                    'description' => 'lorem ipsum... ',          
                    'price' => 11.41,
                    'id' => 30
                ],
                30
            )
            ->andReturn(1);
        
        $crawler = $this->client->request(
            'POST',
            '/items/save',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"name":"item 13","description":"lorem ipsum... ","price":"11.41","id":"30"}'
        );
        
        $this->assertEquals(
            Response::HTTP_OK, 
            $this->client->getResponse()->getStatusCode()
        );
    }
    
}

