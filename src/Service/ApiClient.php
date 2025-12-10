<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class ApiClient
{
    public function __construct(
        private HttpClientInterface $http,
        private RequestStack $stack,
        private string $apiBase,
        private ?string $envToken = null,
    ) {}

    private function base(): string
    {
        // URL de base sans slash final
        return rtrim($this->apiBase, '/');
    }

    private function path(string $path): string
    {
        // On garantit que le path commence par /
        return '/' . ltrim($path, '/');
    }

    private function authHeader(): array
    {
        if ($this->envToken) {
            return ['Authorization' => 'Bearer ' . $this->envToken];
        }
        return [];
    }

    private function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    private function opts(array $extra = []): array
    {
        return array_merge([
            'timeout'       => 10,
            'max_redirects' => 0,
            'headers'       => array_merge(
                $this->defaultHeaders(),
                $this->authHeader(),
            ),
        ], $extra);
    }

    public function get(string $path, bool $withAuth = true): array
    {
        $url = $this->base() . $this->path($path);

        $response = $this->http->request('GET', $url, $this->opts());

        $status = $response->getStatusCode();

        if ($status >= 400) {
            throw new \RuntimeException(sprintf(
                'Erreur HTTP %d lors de l’appel GET %s : %s',
                $status,
                $url,
                $response->getContent(false) // contenu brut, sans relancer une exception interne
            ));
        }

        return $response->toArray();
    }
}
