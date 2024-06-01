<?php

namespace App\Tests\UnitTests;

use App\Service\Reader\LogReader;
use PHPUnit\Framework\TestCase;

class LogReaderTest extends TestCase
{
    public function testReader(): void
    {
        $reader = new LogReader();

        $reader->load(__DIR__ .'/../samples/logs.log');
        $rows = [];

        foreach ($reader->iterator() as $row){
            $rows[] = $row;
        }

        $this->assertCount(20, $rows);

        // Assert correct order of reading (LIFO)
        $this->assertSame('USER-SERVICE - - [18/Aug/2018:10:33:59 +0000] "POST /users HTTP/1.1" 201', $rows[0]);
        $this->assertSame(
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            $rows[\count($rows)-1]
        );
    }
}
