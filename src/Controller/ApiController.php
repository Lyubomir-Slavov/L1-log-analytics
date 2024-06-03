<?php

namespace App\Controller;

use App\DTO\CountApiRequest;
use App\DTO\CountItem;
use App\Repository\LogEntryRepository;

use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class ApiController extends AbstractController
{
    #[Route('/count', name: 'count', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'count of matching results',
        content: new OA\JsonContent(
            ref: new Model(type: CountItem::class),
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'bad input parameter',
    )]
    #[OA\Parameter(
        name: 'serviceNames[]',
        description: 'array of service names',
        in: 'query',
        schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string'))
    )]
    #[OA\Parameter(
        name: 'startDate',
        description: 'start date',
        in: 'query',
        schema: new OA\Schema(type: 'string', format: 'dateTime')
    )]
    #[OA\Parameter(
        name: 'endDate',
        description: 'end date',
        in: 'query',
        schema: new OA\Schema(type: 'string', format: 'dateTime')
    )]
    #[OA\Parameter(
        name: 'statusCode[]',
        description: 'filter on request status code',
        in: 'query',
        schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'integer')),
    )]
    #[OA\Tag(name: 'analytics')]
    public function index(
       #[MapQueryString] ?CountApiRequest $query,
        LogEntryRepository $logEntryRepository,
    ): JsonResponse
    {
        return $this->json(new CountItem($logEntryRepository->getLogEntryCount($query)));
    }
}
