<?php

namespace App\Controller;

use App\Dto\Request\QuoteRequestDto;
use App\UseCase\CalculateQuoteUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    #[Route('/quotes', name: 'quotes_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] QuoteRequestDto $quoteRequest,
        CalculateQuoteUseCase $calculateQuoteUseCase,
    ): JsonResponse {
        $responseDto = $calculateQuoteUseCase->handle($quoteRequest);

        return $this->json($responseDto, Response::HTTP_OK);
    }
}
