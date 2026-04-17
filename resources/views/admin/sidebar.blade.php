<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
        <span class="admin-brand-icon"><img src="{{ asset('images/marketverse-mark.svg') }}" alt="MarketVerse logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 14px;"></span>
        <div>
            <strong>MarketVerse</strong>
            <span>Marketplace control room</span>
        </div>
    </a>

    @foreach($adminNavigation as $section)
        <div class="admin-nav-section">
            <div class="admin-nav-label">{{ $section['label'] }}</div>
            <ul class="admin-nav">
                @foreach($section['items'] as $item)
                    <li>
                        @if(!empty($item['url']))
                            <a href="{{ $item['url'] }}" class="admin-nav-link {{ !empty($item['active']) ? 'active' : '' }}">
                                <span class="admin-nav-main">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </span>
                                @if(isset($item['badge']))
                                    <span class="admin-nav-badge">{{ $item['badge'] }}</span>
                                @endif
                            </a>
                        @else
                            <div class="admin-nav-disabled">
                                <span class="admin-nav-main">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </span>
                                <span class="admin-nav-badge">Soon</span>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</aside>
