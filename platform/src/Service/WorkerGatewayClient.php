<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WorkerGatewayClient
{
    public function __construct(private HttpClientInterface $client) {}

    public function call(string $route, array $payload): array
    {
        $baseUrl = $_ENV['WORKER_GATEWAY_URL'] ?? 'http://worker-gateway:8020';

        $response = $this->client->request('POST', rtrim($baseUrl, '/') . $route, [
            'json' => $payload,
            'timeout' => 300,
        ]);

        return $response->toArray(false);
    }
}