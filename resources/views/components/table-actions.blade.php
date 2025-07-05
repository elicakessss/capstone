@props(['actions' => []])

<div class="flex items-center justify-center space-x-1">
    @foreach($actions as $action)
        @if($action)
            @if(isset($action['url']) && ($action['type'] === 'link'))
                {{-- Link Action --}}
                <a href="{{ $action['url'] }}"
                   class="table-action table-action-{{ $action['type'] }} {{ $action['class'] ?? '' }}"
                   title="{{ $action['title'] ?? $action['tooltip'] ?? '' }}"
                   @if(isset($action['target'])) target="{{ $action['target'] }}" @endif>
                    <i class="{{ $action['icon'] }}"></i>
                </a>
            @elseif(isset($action['action']) || isset($action['onclick']) || ($action['type'] === 'button'))
                {{-- Button Action --}}
                <button type="button"
                        onclick="{{ $action['action'] ?? $action['onclick'] }}"
                        class="table-action table-action-{{ $action['type'] }} {{ $action['class'] ?? '' }}"
                        title="{{ $action['title'] ?? $action['tooltip'] ?? '' }}"
                        @if(isset($action['disabled']) && $action['disabled']) disabled @endif>
                    <i class="{{ $action['icon'] }}"></i>
                </button>
            @elseif(isset($action['form_url']))
                {{-- Form Action --}}
                <form method="{{ $action['method'] ?? 'POST' }}"
                      action="{{ $action['form_url'] }}"
                      class="inline-block"
                      @if(isset($action['confirm'])) onsubmit="return confirm('{{ $action['confirm'] }}')" @endif>
                    @csrf
                    @if(isset($action['method']) && strtoupper($action['method']) !== 'POST')
                        @method($action['method'])
                    @endif
                    <button type="submit"
                            class="table-action table-action-{{ $action['type'] }} {{ $action['class'] ?? '' }}"
                            title="{{ $action['title'] ?? $action['tooltip'] ?? '' }}">
                        <i class="{{ $action['icon'] }}"></i>
                    </button>
                </form>
            @endif
        @endif
    @endforeach
</div>
