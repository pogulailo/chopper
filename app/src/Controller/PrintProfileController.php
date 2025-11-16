<?php

namespace App\Controller;

use App\UseCase\PrintProfile\ListUseCase;
use JsonException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PrintProfileController extends AbstractController
{
    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    #[Route('/print-profiles/{printProfileName}/print-profiles', name: 'print_profile_list', methods: ['GET'])]
    public function list(
        string $printProfileName,
        ListUseCase $useCase,
    ): JsonResponse {
        return $this->json($useCase->handle($printProfileName));
    }
}
