<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Foundation\Application;
use Meilisearch\Client;

final readonly class SearchService
{
    public function __construct(
        private Client $client,
    )
    {
    }

    public function search(string|null $term = null, int $limit = 1_000, int $offset = 0): array
    {
        return $this->client->index('products')->search(
            query: $term,
            searchParams: [
                'limit' => $limit,
                'offset' => $offset,
                'attributesToHighlight' => ['*'],
            ],
        )->getRaw();
    }

    public static function register(Application $app): void
    {
        $app->bind(
            abstract: SearchService::class,
            concrete: fn() => new SearchService(
                client: new Client(
                    url: config('scout.meilisearch.host'),
                    apiKey: config('scout.meilisearch.key'),
                )
            )
        );
    }
}
