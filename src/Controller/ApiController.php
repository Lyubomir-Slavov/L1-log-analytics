<?php

namespace App\Controller;

use App\DTO\CountApiRequest;
use App\Repository\LogEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/count', name: 'count', methods: ['GET'])]
    public function index(
       #[MapQueryString] ?CountApiRequest $query,
        LogEntryRepository $logEntryRepository,
    ): JsonResponse
    {
        $count = $logEntryRepository->getLogEntryCount($query);
        return $this->json([
            'count' => $count
        ]);
    }
}
