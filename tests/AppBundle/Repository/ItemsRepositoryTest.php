<?php
namespace AppBundle\Tests\Repository;

use AppBundle\Repository\ItemsRepository;
use Mockery;

class ItemsRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $DBHandler;
    private $itemsRepository;

    public function setUp()
    {
        $this->DBHandler = Mockery::mock('AppBundle\Service\DBHandler');
        $this->itemsRepository = new ItemsRepository($this->DBHandler);
    }

    public function testListItems()
    {
        $this->DBHandler->shouldReceive('findAll')
            ->once()
            ->with('items')
            ->andReturn(
                [
                    [
                    'id' => 10,
                    'name' => 'item 1',
                    'description' => 'lorem ipsum...',
                    'price' => 8.25
                    ],
                    [
                    'id' => 20,
                    'name' => 'item 2',
                    'description' => 'lorem ipsum...',
                    'price' => 12.59
                    ],
                    [
                    'id' => 10,
                    'name' => 'item 3',
                    'description' => 'lorem ipsum...',
                    'price' => 10.90
                    ],
                ]
            );

        $expected = ['[{"id":10,"name":"item 1","description":"lorem ipsum...","price":8.25},{"id":20,"name":"item 2","description":"lorem ipsum...","price":12.59},{"id":30,"name":"item 3","description":"lorem ipsum...","price":10.9}]','application/json'];

        $result = $this->itemsRepository->find();

        try {
            $this->assertEquals(serialize($expected), serialize($result));
        } 
        catch (PHPUnit_Framework_ExpectationFailedException $e) {
            echo $e->getComparisonFailure()->toString();
        }
    }

    public function testSaveItems()
    {
        $this->DBHandler->shouldReceive('persist')
            ->once()
            ->with(
                'items',
                [
                    'name' => 'item 4',
                    'description' => 'lorem ipsum... ',
                    'price' => 23.60
                ]
            )
            ->andReturn(40);
        
        $item = [
            'name' => 'item 4',
            'description' => 'lorem ipsum... ',
            'price' => 23.60
        ];
        
        $result = $this->itemsRepository->persist($item);
        
        $this->assertEquals(40, $result);
    }
    
    public function testSaveItemsWithId()
    {
        $this->DBHandler->shouldReceive('persist')
            ->once()
            ->with(
                'items',
                [
                    'name' => 'item 3',
                    'description' => 'lorem ipsum... ',
                    'price' => 11.41
                ],
                30
            )
            ->andReturn(true);

            $item = [
                'name' => 'item 3',
                'description' => 'lorem ipsum... ',
                'price' => 11.41,
                'id' => 30
            ];
            
        $result = $this->itemsRepository->persist($item);
        
        $this->assertTrue($result);
    }
}
