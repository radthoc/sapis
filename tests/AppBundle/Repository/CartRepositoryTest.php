<?php
namespace AppBundle\Tests\Repository;

use AppBundle\Repository\CartRepository;
use AppBundle\Service\DBHandler;
use Mockery;

class CartRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $dbHandler;
    private $cartRepository;

    public function setUp()
    {
        $this->dbHandler = Mockery::mock('AppBundle\Service\DBHandler');
        $this->cartRepository = new CartRepository($this->dbHandler);
    }

    public function testAddCart()
    {
        $this->dbHandler->shouldReceive('persist')
            ->once()
            ->with(
                'cart',
                [
                    'customer_id' => '14',
                    'item_id' => '10'
                ]
            )
            ->andReturn(40);
        
        $cart = [
            'customer_id' => '14',
            'item_id' => '10'
        ];
        
        $result = $this->cartRepository->persist($cart);
        
        $this->assertEquals(40, $result);
    }
}
