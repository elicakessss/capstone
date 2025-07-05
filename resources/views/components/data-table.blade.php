@props([
    'title' => '',
    'description' => '',
    'headers' => [],
    'data' => collect(),
    'emptyIcon' => 'fas fa-table',
    'emptyTitle' => 'No data found',
    'emptyDescription' => 'There are no records to display.',
    'pagination' => null,
    'searchable' => false,
    'searchUrl' => '',
    'searchPlaceholder' => 'Search...',
    'searchValue' => '',
    'filters' => [],
    'class' => ''
])

<div class="bg-white rounded-lg shadow overflow-hidden data-table {{ $class }}">
    @if($title || $description || $searchable || count($filters) > 0)
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                @if($title || $description)
                    <div>
                        @if($title)
                            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                        @endif
                        @if($description)
                            <p class="text-sm text-gray-600 mt-1">{{ $description }}</p>
                        @endif
                    </div>
                @endif

                @if($searchable || count($filters) > 0)
                    <div class="flex items-center gap-3">
                        @if($searchable)
                            <form method="GET" action="{{ $searchUrl }}" class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ $searchValue }}"
                                       placeholder="{{ $searchPlaceholder }}"
                                       class="form-input pl-10 pr-4 py-2 w-full sm:w-64 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                @foreach($filters as $filter)
                                    @if(isset($filter['preserve']) && $filter['preserve'])
                                        <input type="hidden" name="{{ $filter['name'] }}" value="{{ $filter['value'] }}">
                                    @endif
                                @endforeach
                            </form>
                        @endif

                        @foreach($filters as $filter)
                            @if($filter['type'] === 'select')
                                <form method="GET" action="{{ $filter['url'] ?? $searchUrl }}" class="flex items-center gap-3">
                                    <select name="{{ $filter['name'] }}"
                                            onchange="this.form.submit()"
                                            class="form-select rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent px-3 py-2">
                                        @foreach($filter['options'] as $value => $label)
                                            <option value="{{ $value }}" {{ $filter['selected'] === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($searchable && $searchValue)
                                        <input type="hidden" name="search" value="{{ $searchValue }}">
                                    @endif
                                </form>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if(count($data) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        @if($pagination)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pagination }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <i class="{{ $emptyIcon }} mx-auto h-12 w-12 text-gray-400 text-4xl mb-4"></i>
            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ $emptyTitle }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $emptyDescription }}</p>
            {{ $empty ?? '' }}
        </div>
    @endif
</div>
