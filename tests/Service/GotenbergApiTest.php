<?php
// Fichier: tests/Service/GotenbergApiTest.php

namespace App\Tests\Service;

use App\Service\GotenbergApi;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GotenbergApiTest extends TestCase
{
    public function testGeneratePdfFromHtml()
    {
        // Crée un faux HttpClientInterface
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        // Crée un faux ResponseInterface avec un contenu fictif
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->expects($this->once())
                     ->method('getStatusCode')
                     ->willReturn(200);
        $responseMock->expects($this->once())
                     ->method('getContent')
                     ->willReturn('PDF Content');

        // Injecte le faux HttpClient dans le service GotenbergApi
        $gotenbergApi = new GotenbergApi($httpClientMock);

        // Configure le faux HttpClient pour retourner le faux Response lorsque la méthode request est appelée
        $httpClientMock->expects($this->once())
                       ->method('request')
                       ->with('POST', 'https://demo.gotenberg.dev/forms/chromium/convert/url', [
                           'headers' => [
                               'Content-Type' => 'multipart/form-data'
                           ],
                           'body' => [
                               'url' => 'https://www.google.com',
                           ],
                       ])
                       ->willReturn($responseMock);

        // Appelle la méthode à tester
        $result = $gotenbergApi->generatePdfFromHtml('dummy.html');

        // Vérifie que la méthode retourne le message attendu
        $this->assertSame('Fichier PDF enregistré avec succès dans ../public/google.pdf', $result);
    }
}
