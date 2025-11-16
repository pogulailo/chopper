<?php

namespace App\Controller;

use App\UseCase\PrinterModel\ListUseCase;
use JsonException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PrinterModelController extends AbstractController
{
    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    #[Route('/printer-models', name: 'printer_model_list', methods: ['GET'])]
    public function list(
        ListUseCase $useCase,
    ): JsonResponse {
        return $this->json($useCase->handle());
    }
}
