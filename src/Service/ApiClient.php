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
        return rtrim($this->apiBase, '/');
    }

    private function path(string $path): string
    {
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
            'headers' => $this->defaultHeaders(),
            'timeout' => 10,
            'max_redirects' => 5,
        ], $extra);
    }

    public function get(string $path, bool $withAuth = true): array
    {
        $url = $this->base() . $this->path($path);

        $options = $withAuth ? $this->opts(['headers' => array_merge($this->defaultHeaders(), $this->authHeader())])
            : $this->opts();

        $response = $this->http->request('GET', $url, $options);

        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException('Unexpected HTTP status code ' . $response->getStatusCode());
        }

        return $response->toArray();
    }

    public function post(string $path, array $data = [], bool $withAuth = false): array
    {
        $url = $this->base() . $this->path($path);

        $options = $this->opts([
            'headers' => $withAuth
                ? array_merge($this->defaultHeaders(), $this->authHeader())
                : $this->defaultHeaders(),
            'json' => $data,
        ]);

        $response = $this->http->request('POST', $url, $options);

        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException('Unexpected HTTP status code ' . $response->getStatusCode());
        }

        return $response->toArray();
    }
}
