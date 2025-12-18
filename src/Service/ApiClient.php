<?php
namespace App\Service;
use RuntimeException;
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

    /**
     * TODO : retourner l'URL de base sans / final
     */
    private function base(): string
    {
        return rtrim($this->apiBase, '/');
    }

    /**
     * TODO : s'assurer que le path commence par un /
     */
    private function path(string $path): string
    {
        return '/' . ltrim($path, '/');
    }

    /**
     * Pour l'instant, pas d'authentification obligatoire
     * TODO : retourner un tableau vide []
     */
    private function authHeader(): array
    {
        return ['Authorization'=>"Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NjU5MDEwOTIsImV4cCI6MTc2NTkwNDY5Miwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJ1c2VybmFtZSI6ImFkbWluQGdtYWlsLmNvbSJ9.hq9om7awl0lvQDmNE50w7EKLNug-0trI5_9Pnc5Nb4-hEFvxaKzoVO2V2j4XxCLlaPHtd8R_bWT5hUhEKCDHgdB6U8lvXuA3PKh1mhoFEUE8HzbpIpBEDLURwDgEU5AonjAgjKsOB3GfzG7pcMUCuKfZtb08cf0viht9CcFKq8oPnAs9MCrGqyJ3Kx1hBcAdThSqOocivmvPUXFzb3lk9udZTCLMPjX0JVcn_yara9J_icqK0l5SRzjYnLphwz7nT6QhkCOnvv7EMXt5l82wzQ1Cm9SIvgLCc2eXwSHBWhG_llJjfm_sz7GkuCkGI662v7iDzCyAh2QJ_6s5-MM2ZQ"];
    }

    /**
     * TODO : retourner un tableau avec Accept et Content-Type en JSON-LD
     */
    private function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
//            'Content-Type' => 'application/ld+json',
        ];
    }

    /**
     * TODO : fusionner headers + options HTTP de base (timeout, max_redirects)
     */
    private function opts(array $extra = []): array
    {
        return array_merge([
            'headers' => array_merge(
                $this->defaultHeaders(),
                $this->authHeader()
            ),
            'timeout' => 10,
            'max_redirects' => 3,
        ], $extra);
    }

    /**
     * TODO :
     * - construire l'URL complète
     * - appeler $this->http->request('GET', ...)
     * - vérifier le code HTTP
     * - retourner le tableau décodé
     */
    public function get(string $path, bool $withAuth = true): array
    {
        $url = $this->base() . $this->path($path);

        $response = $this->http->request('GET', $url, $this->opts());

        $status = $response->getStatusCode();
        if ($status >= 400) {
            throw new RuntimeException(
                "Erreur HTTP $status lors de l'appel GET $url"
            );
        }

        return $response->toArray(false);
    }
}
