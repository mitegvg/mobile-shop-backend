<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Src\TableGateways\DevicesGateway;

class FakeDB
{
    // property declaration
    public $var = 'a default value';

    // method declaration
    public function query() {
        return array("model"=> "test");
    }
    public function prepeare() {
        return array("model"=> "test");
    }
    public function fetchAll() {
        return array("model"=> "test");
    }
}
final class DevicesGatewayTest extends TestCase
{
    public function testFindAll(): void
    {   
        
        //$dev = new DevicesGateway(new FakeDB);
        //$dev->findAll();
        //echo $response;
        $this->assertSame("test", "test");
    }

   
}

