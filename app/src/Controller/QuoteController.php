<?php

namespace App\Controller;

use App\Dto\Request\Quote\QuoteRequestDto;
use App\UseCase\Quote\CalculateQuoteUseCase;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class QuoteController extends AbstractController
{
    #[Route('/quotes', name: 'quotes_create', methods: ['POST'])]
    public function create(
        Request $request,
        CalculateQuoteUseCase $calculateQuoteUseCase,
        Filesystem $filesystem,
    ): JsonResponse {
        $model = $request->files->get('model');

        if (!$model instanceof UploadedFile) {
            throw new InvalidArgumentException('Model must be uploaded');
        }

        $newFilePath = $model->getRealPath() . '.' . $model->getClientOriginalExtension();
        $filesystem->copy($model->getRealPath(), $newFilePath);

        $quoteRequest = new QuoteRequestDto(
            $request->request->get('printerProfile'),
            $request->request->get('printProfile'),
            $request->request->get('materialProfile'),
            $newFilePath,
        );

        $responseDto = $calculateQuoteUseCase->handle($quoteRequest);

        return $this->json($responseDto, Response::HTTP_OK);
    }
}
