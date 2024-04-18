<?php

namespace App\Controller;

use App\Service\GotenbergApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PdfGenerationController extends AbstractController
{
    #[Route('/pdf/generation', name: 'app_pdf_generation')]
    public function index(
        GotenbergApi $gotenbergApi
    ): JsonResponse
    {
        $pdf = $gotenbergApi->generatePdfFromHtml('../public/index.html');

        return $this->json([
            'pdf' => $pdf,
        ]);
    }
}
