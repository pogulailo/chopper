<?php

namespace App\Controller;

use App\UseCase\PrinterProfile\ListUseCase;
use JsonException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PrinterProfileController extends AbstractController
{
    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    #[Route('/printer-profiles', name: 'printer_profile_list', methods: ['GET'])]
    public function list(
        ListUseCase $useCase,
    ): JsonResponse {
        return $this->json($useCase->handle());
    }
}
