<?php

namespace App\Controller;

use App\UseCase\ListPrintersUseCase;
use App\UseCase\ListPrintFilamentProfilesUseCase;
use JsonException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PrinterController extends AbstractController
{
    public function __construct(
        private readonly ListPrintersUseCase $listPrintersUseCase,
        private readonly ListPrintFilamentProfilesUseCase $listPrintFilamentProfilesUseCase,
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    #[Route('/printers', name: 'printers_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $printers = $this->listPrintersUseCase->handle();

        return $this->json($printers, Response::HTTP_OK);
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    #[Route('/printers/{id}', name: 'printers_show', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $profileDto = $this->listPrintFilamentProfilesUseCase->handle($id);

        return $this->json($profileDto, Response::HTTP_OK);
    }
}
