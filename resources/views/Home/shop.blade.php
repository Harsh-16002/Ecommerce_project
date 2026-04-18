@extends('Home.layout')

@section('title', 'MarketVerse | Shop')

@php
    $localAiEnabled = (bool) config('services.ollama.enabled') || app()->environment('local');
@endphp

@push('head')
    <style>
        .ai-shop-shell {
            margin: 0 0 34px;
            padding: 26px;
            border: 1px solid rgba(14, 13, 12, 0.1);
            background:
                radial-gradient(circle at top right, rgba(196, 145, 74, 0.16), transparent 28%),
                linear-gradient(135deg, rgba(255,255,255,0.86), rgba(244, 239, 230, 0.92));
            box-shadow: var(--shadow);
        }
        .ai-shop-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr);
            gap: 24px;
            align-items: start;
        }
        .ai-shop-form {
            display: grid;
            gap: 14px;
        }
        .ai-shop-form textarea {
            min-height: 120px;
            resize: vertical;
        }
        .ai-shop-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }
        .ai-shop-status {
            color: var(--mid-gray);
            font-size: 14px;
            line-height: 1.7;
        }
        .ai-shop-status.error {
            color: var(--danger);
        }
        .ai-shop-results {
            display: grid;
            gap: 14px;
            min-height: 100%;
        }
        .ai-result-card,
        .ai-product-mini {
            border: 1px solid rgba(14, 13, 12, 0.08);
            background: rgba(255,255,255,0.76);
            padding: 16px;
        }
        .ai-result-card h3,
        .ai-product-mini strong {
            font-family: var(--serif);
        }
        .ai-result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
        }
        .ai-filter-pill {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 12px;
            background: rgba(196, 145, 74, 0.12);
            color: var(--black);
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .ai-product-list {
            display: grid;
            gap: 12px;
        }
        .ai-product-mini {
            display: grid;
            grid-template-columns: 68px minmax(0, 1fr);
            gap: 14px;
            align-items: center;
        }
        .ai-product-mini img {
            width: 68px;
            height: 68px;
            object-fit: cover;
            border-radius: 12px;
            background: rgba(14, 13, 12, 0.04);
        }
        @media (max-width: 900px) {
            .ai-shop-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 680px) {
            .ai-shop-shell {
                padding: 18px;
            }
            .ai-shop-actions {
                flex-direction: column;
                align-items: stretch;
            }
            .ai-shop-actions .solid-btn,
            .ai-shop-actions .outline-btn {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="page-container">
            <div class="section-header reveal">
                <div>
                    <div class="eyebrow">Shop Collection</div>
                    <h1 class="section-title">Browse the full catalog</h1>
                    <p class="section-copy">Filter by category, search by keyword, and sort your live products without leaving the new premium storefront.</p>
                </div>
                @auth
                    <a href="{{ url('mycart') }}" class="solid-btn">Open Cart</a>
                @else
                    <a href="{{ route('login') }}" class="solid-btn">Login to Use Cart</a>
                @endauth
            </div>

            <section class="ai-shop-shell reveal" id="aiShopAssistant">
                <div class="ai-shop-grid">
                    <div>
                        <div class="eyebrow">AI Concierge</div>
                        <h2 class="section-title" style="font-size: clamp(28px, 3vw, 40px); margin-top: 16px;">Describe what you want, and the store will shape the filters for you.</h2>
                        <p class="section-copy">This uses a free local Ollama model to recommend search terms, category, sort order, and a few matching products from your live catalog.</p>

                        <div class="ai-shop-form" style="margin-top: 22px;">
                            <textarea class="textarea-field" id="aiShopPrompt" placeholder="Try: I need an affordable gift for a gamer, or show me items with high stock for quick delivery."></textarea>
                            <div class="ai-shop-actions">
                                <button type="button" class="solid-btn" id="aiShopAsk" @disabled(! $localAiEnabled)>Ask AI Concierge</button>
                                <button type="button" class="outline-btn" id="aiShopApply" hidden>Apply AI Filters</button>
                                <div class="ai-shop-status" id="aiShopStatus">{{ $localAiEnabled ? 'Ready when you are.' : 'AI Concierge is disabled on this deployment.' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="ai-shop-results">
                        <article class="ai-result-card" id="aiShopSummary">
                            <h3 style="font-size: 28px;">AI suggestions will appear here</h3>
                            <p class="section-copy" style="margin-top: 10px;">
                                @if($localAiEnabled)
                                    Ask for a budget, category, occasion, or shopping goal and the assistant will recommend filters you can apply immediately.
                                @else
                                    This assistant is available in local development with Ollama, or in environments where `OLLAMA_ENABLED=true` is configured with a reachable AI backend.
                                @endif
                            </p>
                        </article>
                        <div class="ai-product-list" id="aiShopProducts"></div>
                    </div>
                </div>
            </section>

            <form id="shopFilterForm" action="{{ route('shop.index') }}" method="GET" class="grid-4 reveal" style="grid-template-columns: 1.4fr 1fr 1fr auto; margin-bottom: 28px;">
                <input class="input-field" type="text" name="search" value="{{ $searchTerm }}" placeholder="Search products">
                <select class="select-field" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['name'] }}" @selected($selectedCategory === $category['name'])>{{ $category['name'] }}</option>
                    @endforeach
                </select>
                <select class="select-field" name="sort">
                    <option value="latest" @selected($selectedSort === 'latest')>Newest First</option>
                    <option value="price_low" @selected($selectedSort === 'price_low')>Price Low to High</option>
                    <option value="price_high" @selected($selectedSort === 'price_high')>Price High to Low</option>
                    <option value="stock" @selected($selectedSort === 'stock')>Highest Stock</option>
                </select>
                <button type="submit" class="solid-btn">Apply</button>
            </form>

            @if($data->count())
                <div class="grid-4">
                    @foreach($data as $index => $product)
                        <article class="product-card reveal delay-{{ $index % 4 }}">
                            <div class="product-media">
                                <div class="product-badge">{{ $product->category ?? 'Featured' }}</div>
                                <div class="product-stock">{{ (int) $product->quantity > 0 ? $product->quantity . ' left' : 'Sold out' }}</div>
                                <div class="product-quick-actions">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-quick-btn" aria-label="View {{ $product->title }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ auth()->check() ? url('add_cart', $product->id) : route('login') }}" class="product-quick-btn" aria-label="{{ auth()->check() ? 'Add ' . $product->title . ' to cart' : 'Login to add ' . $product->title . ' to cart' }}">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                                <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->title }}">
                            </div>
                            <div class="product-body">
                                <div class="product-topline">
                                    <span class="category">{{ $product->category ?? 'Collection' }}</span>
                                </div>
                                <div class="product-title">{{ $product->title }}</div>
                                <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 84) }}</p>
                                <div class="price-row" style="margin-top: 18px;">
                                    <span class="price-main">Rs. {{ number_format((float) $product->price, 2) }}</span>
                                </div>
                                <div class="product-buttons">
                                    <a href="{{ url('product_details', $product->id) }}" class="product-btn view">View</a>
                                    <a href="{{ auth()->check() ? url('add_cart', $product->id) : route('login') }}" class="product-btn cart">{{ auth()->check() ? 'Add' : 'Login for Cart' }}</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pagination-wrap" style="margin-top: 34px;">
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="empty-state reveal">
                    <h2 class="section-title" style="font-size: 34px;">No products matched this filter</h2>
                    <p class="section-copy" style="margin-left: auto; margin-right: auto;">Try clearing the category, changing sort, or using a broader search term.</p>
                    <a href="{{ route('shop.index') }}" class="solid-btn" style="margin-top: 20px;">Reset Catalog</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const askButton = document.getElementById('aiShopAsk');
            const applyButton = document.getElementById('aiShopApply');
            const promptField = document.getElementById('aiShopPrompt');
            const status = document.getElementById('aiShopStatus');
            const summary = document.getElementById('aiShopSummary');
            const productList = document.getElementById('aiShopProducts');
            const shopForm = document.getElementById('shopFilterForm');
            const searchField = shopForm?.querySelector('[name="search"]');
            const categoryField = shopForm?.querySelector('[name="category"]');
            const sortField = shopForm?.querySelector('[name="sort"]');
            let pendingFilters = null;

            if (!askButton || !promptField || !status || !summary || !productList || !shopForm) {
                return;
            }

            const setStatus = (message, isError = false) => {
                status.textContent = message;
                status.classList.toggle('error', isError);
            };

            askButton.addEventListener('click', async () => {
                const prompt = promptField.value.trim();

                if (!prompt) {
                    setStatus('Describe what you want first.', true);
                    promptField.focus();
                    return;
                }

                askButton.disabled = true;
                applyButton.hidden = true;
                pendingFilters = null;
                setStatus('Thinking with local Ollama...');

                try {
                    const response = await fetch('{{ route('shop.ai.assistant') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
                        },
                        body: JSON.stringify({ prompt }),
                    });

                    const payload = await response.json();

                    if (!response.ok) {
                        throw new Error(payload.message || 'The shopping assistant is unavailable right now.');
                    }

                    pendingFilters = payload.filters || null;
                    applyButton.hidden = !pendingFilters;

                    const filterBits = [];

                    if (pendingFilters?.search) {
                        filterBits.push(`<span class="ai-filter-pill">Search: ${pendingFilters.search}</span>`);
                    }

                    if (pendingFilters?.category) {
                        filterBits.push(`<span class="ai-filter-pill">Category: ${pendingFilters.category}</span>`);
                    }

                    if (pendingFilters?.sort) {
                        filterBits.push(`<span class="ai-filter-pill">Sort: ${pendingFilters.sort.replace('_', ' ')}</span>`);
                    }

                    summary.innerHTML = `
                        <h3 style="font-size: 28px;">Recommended shopping path</h3>
                        <p class="section-copy" style="margin-top: 10px;">${payload.message || 'Here is a suggested direction based on your prompt.'}</p>
                        <div class="ai-result-meta">${filterBits.join('')}</div>
                    `;

                    productList.innerHTML = (payload.products || []).map((product) => `
                        <article class="ai-product-mini">
                            <img src="${product.image ?? ''}" alt="${product.title}">
                            <div>
                                <strong style="font-size: 22px;">${product.title}</strong>
                                <p class="section-copy" style="margin-top: 6px;">${product.category || 'Collection'} • Rs. ${product.price}</p>
                                <a href="${product.url}" class="link-inline" style="margin-top: 8px; display: inline-flex;">View product</a>
                            </div>
                        </article>
                    `).join('');

                    setStatus('AI recommendations are ready.');
                } catch (error) {
                    setStatus(error.message || 'Could not load AI suggestions.', true);
                } finally {
                    askButton.disabled = false;
                }
            });

            applyButton?.addEventListener('click', () => {
                if (!pendingFilters) {
                    return;
                }

                if (searchField) {
                    searchField.value = pendingFilters.search || '';
                }

                if (categoryField) {
                    categoryField.value = pendingFilters.category || '';
                }

                if (sortField) {
                    sortField.value = pendingFilters.sort || 'latest';
                }

                shopForm.submit();
            });
        })();
    </script>
@endpush
