<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GotenbergClient;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate/pdf', name: 'app_view_pdf')]
    public function view(Request $request, GotenbergClient $gotenbergClient): Response
    {

        $url = $request->query->get('url');
        $pdfContent = $gotenbergClient->convertUrlToPdf($url);

        $response = new Response($pdfContent);

        // $response = new Response($url);

        // $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}