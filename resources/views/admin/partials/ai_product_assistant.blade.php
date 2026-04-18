@php
    $localAiEnabled = (bool) config('services.ollama.enabled') || app()->environment('local');
@endphp

<div class="admin-ai-panel" data-ai-product-panel data-endpoint="{{ route('admin.ai.product-description') }}">
    <div>
        <div class="admin-ai-kicker">Free Local AI</div>
        <h4 class="admin-card-title">Generate product copy with Ollama</h4>
        <div class="admin-muted">
            @if($localAiEnabled)
                Use your title, category, price, quantity, and any draft notes from the description field to create a cleaner product description.
            @else
                This deployment has local AI turned off. The generator works in local development with Ollama, or when `OLLAMA_ENABLED=true` is set for a supported environment.
            @endif
        </div>
    </div>

    <div class="admin-ai-actions">
        <button type="button" class="admin-btn-outline" data-ai-generate-product @disabled(! $localAiEnabled)>
            <i class="fa fa-magic"></i> Generate Description
        </button>
        <div class="admin-ai-status" data-ai-status>{{ $localAiEnabled ? 'Ready to generate' : 'Unavailable on this deployment' }}</div>
    </div>

    <div class="admin-ai-suggestions" data-ai-highlights hidden></div>
</div>

@push('admin_scripts')
    <script>
        (() => {
            const panels = document.querySelectorAll('[data-ai-product-panel]');

            panels.forEach((panel) => {
                const form = panel.closest('form');
                const button = panel.querySelector('[data-ai-generate-product]');
                const status = panel.querySelector('[data-ai-status]');
                const highlightWrap = panel.querySelector('[data-ai-highlights]');

                if (!form || !button || !status) {
                    return;
                }

                const titleField = form.querySelector('[name="title"]');
                const categoryField = form.querySelector('[name="category"]');
                const priceField = form.querySelector('[name="price"]');
                const quantityField = form.querySelector('[name="quantity"]');
                const descriptionField = form.querySelector('[name="description"]');

                const setStatus = (message, isError = false) => {
                    status.textContent = message;
                    status.classList.toggle('error', isError);
                };

                button.addEventListener('click', async () => {
                    if (!titleField?.value.trim()) {
                        setStatus('Add a product title first.', true);
                        titleField?.focus();
                        return;
                    }

                    button.disabled = true;
                    setStatus('Generating with local Ollama...');
                    highlightWrap.hidden = true;
                    highlightWrap.innerHTML = '';

                    try {
                        const response = await fetch(panel.dataset.endpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
                            },
                            body: JSON.stringify({
                                title: titleField.value,
                                category: categoryField?.value ?? '',
                                price: priceField?.value ?? '',
                                quantity: quantityField?.value ?? '',
                                notes: descriptionField?.value ?? '',
                            }),
                        });

                        const payload = await response.json();

                        if (!response.ok) {
                            throw new Error(payload.message || 'The AI request failed.');
                        }

                        if (descriptionField && payload.description) {
                            descriptionField.value = payload.description;
                        }

                        if (Array.isArray(payload.highlights) && payload.highlights.length) {
                            highlightWrap.hidden = false;
                            highlightWrap.innerHTML = payload.highlights
                                .map((item) => `<span class="admin-ai-pill">${item}</span>`)
                                .join('');
                        }

                        setStatus('Description generated successfully.');
                    } catch (error) {
                        setStatus(error.message || 'Could not generate description.', true);
                    } finally {
                        button.disabled = false;
                    }
                });
            });
        })();
    </script>
@endpush
