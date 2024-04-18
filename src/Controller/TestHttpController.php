<?php

namespace App\Controller;

use App\Service\TestingHttpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TestHttpController extends AbstractController
{
    #[Route('/test/http', name: 'app_test_http')]
    public function index(
        TestingHttpService $testingHttpService
    ): JsonResponse
    {
        $content = $testingHttpService->fetchGitHubInformation();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestHttpController.php',
            'content' => $content,
        ]);
    }
}
