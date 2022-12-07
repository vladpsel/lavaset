<form action="#" class="form-main mb-1" onsubmit="e.preventDefault()">
    <fieldset>
        <input id="search-input" type="text" placeholder="Пошук">
    </fieldset>
</form>

@if(empty($items) || count($items) < 1)
    <p>Немає єлементів</p>
@else
    <ul class="aside-bar__list">
        @foreach($items as $item)
            <li data-text="@foreach($item as $searchItem){{ $searchItem->title . ' ' }}@endforeach">
                <p class="mb-1">{{ $item[0]->title  }}</p>
                <ul class="list">
                    @foreach($item as $singleItem)
                        <li>
                            <a href="{{ route($route, $singleItem->id) }}" class="lang-item">{{ $singleItem->locale }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
@endif
