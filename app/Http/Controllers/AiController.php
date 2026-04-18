<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OllamaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AiController extends Controller
{
    public function productDescription(Request $request, OllamaService $ollama): JsonResponse
    {
        if (! $this->aiEnabled()) {
            return response()->json([
                'message' => 'Local AI is disabled on this deployment. Use Ollama in local development or connect a hosted AI provider.',
            ], 503);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:100',
            'quantity' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1200',
        ]);

        try {
            $result = $ollama->generateProductDescription($validated);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 503);
        }

        return response()->json($result);
    }

    public function shopAssistant(Request $request, OllamaService $ollama): JsonResponse
    {
        if (! $this->aiEnabled()) {
            return response()->json([
                'message' => 'AI Concierge is disabled on this deployment. It is available locally with Ollama.',
            ], 503);
        }

        $validated = $request->validate([
            'prompt' => 'required|string|max:800',
        ]);

        $products = Product::latest('id')
            ->take(24)
            ->get(['id', 'title', 'category', 'price', 'quantity', 'description']);

        $catalog = [
            'categories' => $products->pluck('category')
                ->filter()
                ->unique()
                ->values()
                ->all(),
            'products' => $products->map(function (Product $product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'category' => $product->category,
                    'price' => (float) $product->price,
                    'quantity' => (int) $product->quantity,
                    'description' => mb_substr((string) $product->description, 0, 160),
                ];
            })->all(),
        ];

        try {
            $result = $ollama->shoppingAssistant($validated['prompt'], $catalog);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 503);
        }

        $recommendedProducts = Product::whereIn('id', $result['product_ids'])
            ->get(['id', 'title', 'category', 'price', 'image'])
            ->sortBy(fn (Product $product) => array_search($product->id, $result['product_ids'], true))
            ->values()
            ->map(function (Product $product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'category' => $product->category,
                    'price' => number_format((float) $product->price, 2),
                    'url' => url('product_details', $product->id),
                    'image' => $product->image ? asset('products/' . $product->image) : null,
                ];
            })
            ->all();

        return response()->json([
            'message' => $result['message'],
            'filters' => $result['filters'],
            'products' => $recommendedProducts,
        ]);
    }

    private function aiEnabled(): bool
    {
        if ((bool) config('services.ollama.enabled')) {
            return true;
        }

        return App::environment('local');
    }
}
