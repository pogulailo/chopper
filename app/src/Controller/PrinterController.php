<?php

namespace App\Controller;

use App\UseCase\ListPrintersUseCase;
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
}


