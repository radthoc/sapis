<?php
namespace AppBundle\Tests\Repository;

use AppBundle\Repository\CartRepository;
use Mockery;

class CartRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $DBHandler;
    private $cartRepository;

    public function setUp()
    {
        $this->DBHandler = Mockery::mock('AppBundle\Service\DBHandler');
        $this->cartRepository = new CartRepository($this->DBHandler);
    }

    public function testAddCart()
    {
        $this->DBHandler->shouldReceive('persist')
            ->once()
            ->with(
                'cart',
                [
                    'customer_id' => '14',
                    'item_id' => '10'
                ]
            )
            ->andReturn(31);
        
        $cart = [
            'customer_id' => '14',
            'item_id' => '10'
        ];
        
        $result = $this->cartRepository->persist($cart);
        
        $this->assertEquals(31, $result);
    }
}
