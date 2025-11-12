@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Route as R;

    // Helpers d'affichage
    $currentType = $activeType; // alias ou null
    $q        = $filters['q'] ?? '';
    $sort     = $filters['sort'] ?? 'recent';
    $perPage  = $filters['per_page'] ?? 24;

    $typeLabel = function ($alias) use ($availableTypes) {
        $row = collect($availableTypes)->firstWhere('alias', $alias);
        return $row['label'] ?? Str::title(str_replace('-', ' ', $alias));
    };

    // Route vers la page d'un tag (fallback si ton nom diffère)
    $tagShowRoute = R::has('helpcenter.tags.show')
        ? 'helpcenter.tags.show'
        : (R::has('tags.show') ? 'tags.show' : null);

    // On persiste juste le filtre "type" lors de la nav entre tags
    $persistQuery = [];
    if (!empty($currentType)) $persistQuery['type'] = $currentType;
@endphp

<x-people::layouts.master>
    <div class="max-w-6xl mx-auto px-4 py-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <flux:badge :color="$tag->color" variant="pill" size="sm">{{ $tag->name }}</flux:badge>
                    <span class="text-slate-700">Tag</span>
                </h1>
                @if($tag->description)
                    <p class="text-slate-500 mt-2">{{ $tag->description }}</p>
                @endif
            </div>

            {{-- Type selector --}}
            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="q" value="{{ $q }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <label class="text-sm text-slate-600">Filter by type</label>
                <select name="type" class="border rounded px-2 py-1 text-sm"
                        onchange="this.form.submit()">
                    <option value="">All types</option>
                    @foreach($availableTypes as $t)
                        <option value="{{ $t['alias'] }}" @selected($currentType === $t['alias'])>
                            {{ $t['label'] }} ({{ $t['total'] }})
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Filters (q, sort, per_page) --}}
        <form method="GET" class="flex flex-wrap items-center gap-2 mb-6">
            <input type="hidden" name="type" value="{{ $currentType }}">
            <input name="q" value="{{ $q }}" placeholder="Search in items..."
                   class="border rounded px-3 py-2 text-sm w-64" />
            <select name="sort" class="border rounded px-2 py-2 text-sm">
                <option value="recent" @selected($sort==='recent')>Most recent</option>
                <option value="name"   @selected($sort==='name')>Name (A–Z)</option>
            </select>
            <select name="per_page" class="border rounded px-2 py-2 text-sm">
                @foreach([12,24,48,96] as $n)
                    <option value="{{ $n }}" @selected($perPage==$n)>{{ $n }}/page</option>
                @endforeach
            </select>
            <button class="px-3 py-2 text-sm rounded bg-slate-800 text-white">Apply</button>
            @if($q || $currentType || $sort!=='recent' || $perPage!=24)
                <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $tag) }}"
                   class="text-sm text-slate-500">Reset</a>
            @endif
        </form>

        {{-- Content --}}
        @if($currentType && $items)
            {{-- One type, paginated --}}
            <div class="mb-3">
                <h2 class="text-lg font-medium">{{ $typeLabel($currentType) }}</h2>
                <p class="text-slate-500 text-sm">
                    Showing {{ $items->total() }} {{ Str::plural('item', $items->total()) }}
                    @if($q) for query “{{ $q }}” @endif
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($items as $item)
                    <div class="rounded border p-3 bg-white">
                        <div class="font-medium">
                            {{ $item->name ?? $item->title ?? ('#'.$item->id) }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            Type: {{ class_basename($item) }}
                            @if(isset($item->created_at)) • {{ optional($item->created_at)->diffForHumans() }} @endif
                        </div>

                        @if($item->relationLoaded('tags'))
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach($item->tags as $t)
                                    @php
                                        $href = $tagShowRoute
                                            ? route($tagShowRoute, $t) . (empty($persistQuery) ? '' : ('?'.http_build_query($persistQuery)))
                                            : null;
                                    @endphp
                                    @if($href)
                                        <a href="{{ $href }}" class="inline-block focus:outline-none focus:ring rounded">
                                            <flux:badge :color="$t->color" variant="pill" size="xs">{{ $t->name }}</flux:badge>
                                        </a>
                                    @else
                                        <flux:badge :color="$t->color" variant="pill" size="xs">{{ $t->name }}</flux:badge>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-slate-500">No items found.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        @else
            {{-- All types — grouped previews --}}
            @forelse($samplesByType as $alias => $block)
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-lg font-medium">
                            {{ $block['meta']['label'] }} ({{ $block['meta']['total'] }})
                        </h2>
                        <a class="text-sm text-slate-600 hover:underline"
                           href="{{ request()->fullUrlWithQuery(['type' => $alias]) }}">
                            View all
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($block['items'] as $item)
                            <div class="rounded border p-3 bg-white">
                                <div class="font-medium">
                                    {{ $item->name ?? $item->title ?? ('#'.$item->id) }}
                                </div>
                                <div class="text-xs text-slate-500 mt-1">
                                    Type: {{ class_basename($item) }}
                                    @if(isset($item->created_at)) • {{ optional($item->created_at)->diffForHumans() }} @endif
                                </div>

                                @if($item->relationLoaded('tags'))
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($item->tags as $t)
                                            @php
                                                $href = $tagShowRoute
                                                    ? route($tagShowRoute, $t) . (empty($persistQuery) ? '' : ('?'.http_build_query($persistQuery)))
                                                    : null;
                                            @endphp
                                            @if($href)
                                                <a href="{{ $href }}" class="inline-block focus:outline-none focus:ring rounded">
                                                    <flux:badge :color="$t->color" variant="pill" size="xs">{{ $t->name }}</flux:badge>
                                                </a>
                                            @else
                                                <flux:badge :color="$t->color" variant="pill" size="xs">{{ $t->name }}</flux:badge>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-slate-500">No items yet.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <p class="text-slate-500">No content is associated with this tag yet.</p>
            @endforelse
        @endif
    </div>
</x-people::layouts.master>
