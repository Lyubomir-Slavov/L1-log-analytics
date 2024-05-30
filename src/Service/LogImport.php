<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\LogEntry;
use App\Repository\LogEntryRepository;
use App\Service\Reader\Reader;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class LogImport
{
    public function __construct(
        private LogEntryRepository $logEntryRepository,
        private Reader $reader,
        private SerializerInterface $serializer,
    )
    {
    }

    public function import(string $path, ?LogEntry $lastImportedLogEntry = null): void
    {
        $this->reader->load($path);
        $counter = 0;
        foreach ($this->reader->iterator() as $row){
            $logEntry = $this->serializer->deserialize(
                $row,
                LogEntry::class,
                'log',
                [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]
            );
            if(null !== $lastImportedLogEntry && $lastImportedLogEntry->getDate() <= $logEntry->getDate()){
                break;
            }

            $this->logEntryRepository->save($logEntry, $counter % 200 === 0);
        }

        $this->logEntryRepository->flush();
    }
}
