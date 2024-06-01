<?php

namespace App\Factory;

use App\Entity\LogEntry;
use App\Enum\HTTPMethod;
use App\Repository\LogEntryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<LogEntry>
 *
 * @method        LogEntry|Proxy                     create(array|callable $attributes = [])
 * @method static LogEntry|Proxy                     createOne(array $attributes = [])
 * @method static LogEntry|Proxy                     find(object|array|mixed $criteria)
 * @method static LogEntry|Proxy                     findOrCreate(array $attributes)
 * @method static LogEntry|Proxy                     first(string $sortedField = 'id')
 * @method static LogEntry|Proxy                     last(string $sortedField = 'id')
 * @method static LogEntry|Proxy                     random(array $attributes = [])
 * @method static LogEntry|Proxy                     randomOrCreate(array $attributes = [])
 * @method static LogEntryRepository|RepositoryProxy repository()
 * @method static LogEntry[]|Proxy[]                 all()
 * @method static LogEntry[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static LogEntry[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static LogEntry[]|Proxy[]                 findBy(array $attributes)
 * @method static LogEntry[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static LogEntry[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class LogEntryFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'date' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'protocol' => 'HTTP/1.1',
            'requestMethod' => self::faker()->randomElement(HTTPMethod::cases()),
            'route' => self::faker()->text(255),
            'serviceName' => self::faker()->city(),
            'statusCode' => self::faker()->numberBetween(100,511),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(LogEntry $logEntry): void {})
        ;
    }

    protected static function getClass(): string
    {
        return LogEntry::class;
    }
}
