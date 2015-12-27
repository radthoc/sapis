<?php
namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartControllerTest extends WebTestCase
{
    private $client;
    
    public function setUp(){
        $this->markTestSkipped(
            'This test is still in the oven.'
        );
        
        $this->client = static::createClient();
    }
    
    public function testListItemsKO()
    {
        $crawler = $this->client->request('POST', '/cart/add', array('name' => 'item 3'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        
        $this->assertEquals(
            Response::HTTP_BAD_REQUEST, 
            $this->client->getResponse()->getStatusCode()
        );
    }
    
    public function testListItemsOK()
    {
        $crawler = $this->client->request('GET', '/cart/add');

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
}