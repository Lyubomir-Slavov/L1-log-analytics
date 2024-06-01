<?php

namespace App\Tests\IntegrationTests;

use App\Entity\LogEntry;
use App\Enum\HTTPMethod;
use App\Repository\LogEntryRepository;
use App\Service\LogImport;
use App\Service\Reader\LogReader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class LogImportTest extends KernelTestCase
{
    /**
     * @var array<LogEntry> $store
     */
    private array $store = [];

    public function testImport(): void
    {
        self::bootKernel();
        $serializer = static::getContainer()->get(SerializerInterface::class);
        $importer = new LogImport($this->mockLoadEntityRepository(),new LogReader(), $serializer);
        $importer->import(__DIR__ .'/../samples/logs.log');

        $this->assertCount(20, $this->store);
        $this->assertSame('USER-SERVICE', $this->store[0]->getServiceName());
        $this->assertEquals(new \DateTime('2018-08-18T10:33:59+0000'), $this->store[0]->getDate());
        $this->assertSame(201, $this->store[0]->getStatusCode());
        $this->assertSame(HTTPMethod::POST, $this->store[0]->getRequestMethod());
        $this->assertSame('/users', $this->store[0]->getRoute());
        $this->assertSame('HTTP/1.1', $this->store[0]->getProtocol());
    }

    private function mockLoadEntityRepository(): LogEntryRepository
    {
        $repo = $this->createMock(LogEntryRepository::class);
        $repo->method('flush')->willReturnCallback(function(){});
        $repo->method('save')->willReturnCallback(function (LogEntry $logEntry, bool $flush) {
            $this->store[] = $logEntry;
        });

        return $repo;
    }
}
