<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OllamaService
{
    public function generateProductDescription(array $payload): array
    {
        $title = trim((string) ($payload['title'] ?? ''));
        $category = trim((string) ($payload['category'] ?? ''));
        $price = trim((string) ($payload['price'] ?? ''));
        $quantity = trim((string) ($payload['quantity'] ?? ''));
        $notes = trim((string) ($payload['notes'] ?? ''));

        $prompt = <<<PROMPT
You write concise, trustworthy product copy for an ecommerce admin.
Return valid JSON only with this exact shape:
{
  "description": "string",
  "highlights": ["string", "string", "string"]
}

Rules:
- Keep the description between 70 and 120 words.
- Do not invent precise specs, materials, warranties, or certifications.
- If details are missing, write in a flexible marketing style without fake facts.
- Mention category and value clearly.
- Highlights must be short phrases, 3 items max.

Product input:
- Title: {$title}
- Category: {$category}
- Price: {$price}
- Stock quantity: {$quantity}
- Notes: {$notes}
PROMPT;

        $response = $this->generateJson($prompt);

        return [
            'description' => trim((string) ($response['description'] ?? '')),
            'highlights' => collect($response['highlights'] ?? [])
                ->filter(fn ($item) => is_string($item) && trim($item) !== '')
                ->map(fn (string $item) => trim($item))
                ->take(3)
                ->values()
                ->all(),
        ];
    }

    public function shoppingAssistant(string $prompt, array $catalog): array
    {
        $catalogJson = json_encode($catalog, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $instruction = <<<PROMPT
You are a storefront shopping assistant.
Use the catalog data to help a shopper narrow choices.
Return valid JSON only with this exact shape:
{
  "message": "string",
  "filters": {
    "search": "string",
    "category": "string",
    "sort": "latest|price_low|price_high|stock"
  },
  "product_ids": [1, 2, 3]
}

Rules:
- Keep the message to 2 short sentences.
- Recommend at most 3 products.
- Only use categories and product ids that exist in the provided catalog.
- If the shopper is vague, set category to an empty string and use a helpful search phrase.
- If budget-sensitive, prefer price_low. If availability-sensitive, prefer stock. Otherwise use latest.

Shopper request:
{$prompt}

Catalog:
{$catalogJson}
PROMPT;

        $response = $this->generateJson($instruction);
        $filters = is_array($response['filters'] ?? null) ? $response['filters'] : [];

        return [
            'message' => trim((string) ($response['message'] ?? '')),
            'filters' => [
                'search' => trim((string) ($filters['search'] ?? '')),
                'category' => trim((string) ($filters['category'] ?? '')),
                'sort' => in_array(($filters['sort'] ?? 'latest'), ['latest', 'price_low', 'price_high', 'stock'], true)
                    ? $filters['sort']
                    : 'latest',
            ],
            'product_ids' => collect($response['product_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->filter(fn (int $id) => $id > 0)
                ->take(3)
                ->values()
                ->all(),
        ];
    }

    private function generateJson(string $prompt): array
    {
        $baseUrl = rtrim((string) config('services.ollama.base_url'), '/');
        $model = (string) config('services.ollama.model');
        $timeout = (int) config('services.ollama.timeout', 45);

        if ($baseUrl === '' || $model === '') {
            throw new RuntimeException('Ollama is not configured. Set OLLAMA_BASE_URL and OLLAMA_MODEL first.');
        }

        try {
            $response = Http::timeout($timeout)
                ->acceptJson()
                ->post($baseUrl . '/api/generate', [
                    'model' => $model,
                    'prompt' => $prompt,
                    'stream' => false,
                    'format' => 'json',
                ])
                ->throw();
        } catch (RequestException $exception) {
            throw new RuntimeException($this->requestErrorMessage($exception), previous: $exception);
        }

        $content = (string) data_get($response->json(), 'response', '');

        if ($content === '') {
            throw new RuntimeException('Ollama returned an empty response.');
        }

        $decoded = json_decode($this->extractJson($content), true);

        if (! is_array($decoded)) {
            throw new RuntimeException('Ollama returned invalid JSON.');
        }

        return $decoded;
    }

    private function extractJson(string $content): string
    {
        $trimmed = trim($content);

        if (str_starts_with($trimmed, '{') || str_starts_with($trimmed, '[')) {
            return $trimmed;
        }

        if (preg_match('/(\{.*\}|\[.*\])/s', $trimmed, $matches) === 1) {
            return $matches[1];
        }

        return $trimmed;
    }

    private function requestErrorMessage(RequestException $exception): string
    {
        $status = $exception->response?->status();
        $body = trim((string) $exception->response?->body());

        if ($status === 404) {
            return 'Ollama could not find the configured model. Run "ollama pull ' . config('services.ollama.model') . '" first.';
        }

        if ($body !== '') {
            return 'Ollama request failed: ' . $body;
        }

        return 'Could not reach Ollama. Make sure "ollama serve" is running locally.';
    }
}
