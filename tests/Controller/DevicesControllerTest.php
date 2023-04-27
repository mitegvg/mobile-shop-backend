<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Src\Controller\DevicesController;

final class DevicesControllerTest extends TestCase
{
    public function testNotFoundResponse(): void
    {   
        $dc = new DevicesController('db', 'requestMethod');
        
        $res = $dc->notFoundResponse();
        $this->assertSame($res['status_code_header'], "HTTP/1.1 404 Not Found");
    }

   
}

