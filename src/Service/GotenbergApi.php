<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GotenbergApi
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function generatePdfFromHtml($htmlFilePath)
    {
        $htmlContent = file_get_contents($htmlFilePath);

        try {
            $response = $this->httpClient->request('POST', 'https://demo.gotenberg.dev/forms/chromium/convert/url', [
                'headers' => [
                    'Content-Type'=>'multipart/form-data'
                ],
                'body' => [
                    'url' => 'https://www.google.com',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $pdfContent = $response->getContent();

                $pdfFilePath = '../public/google.pdf';

                file_put_contents($pdfFilePath, $pdfContent);

                return 'Fichier PDF enregistré avec succès dans ' . $pdfFilePath;
            }
            else {
                return 'Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getInfo('http_code');
            }
        } catch (TransportExceptionInterface $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
