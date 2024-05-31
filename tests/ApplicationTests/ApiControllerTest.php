<?php

declare(strict_types=1);

namespace ApplicationTests;

use App\Factory\LogEntryFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;


class ApiControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    /**
     * @dataProvider filterProvider
     */
    public function testFilters(string $query, int $expectedCount): void
    {
        $client = static::createClient();
        LogEntryFactory::createMany(
            3,
            ['serviceName' => 'One-Service','statusCode' => '200', 'date' => faker()->dateTimeThisMonth()]
        );
        LogEntryFactory::createMany(
            5,
            [
                'serviceName' => 'Two-Service',
                'statusCode' => '400',
                'date' => faker()->dateTimeBetween('-2 years', '-1 years')
            ]
        );

        $client->request('GET', "/count?{$query}");

        self::assertResponseIsSuccessful();
        $content = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame($expectedCount, $content['count']);
    }

    public function filterProvider(): array
    {
        return [
            'No filters' => ['', 8],
            'Filter by statusCode' => ['statusCode=200', 3],
            'Filter by multiple statusCode' => ['statusCode[]=200&statusCode[]=400', 8],
            'Filter by service name' => ['serviceNames=Two-Service', 5],
            'Filter by startDate' => [
                'startDate=' . (new \DateTime('first day of this month'))->format('Y-m-d H:i:s'),
                3
            ],
            'Filter by endDate' => [
                'endDate=' . (new \DateTime('-1 years'))->format('Y-m-d H:i:s'),
                5
            ]
        ];
    }
}
