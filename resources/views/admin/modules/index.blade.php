@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
      <div class="admin-aside__bar">
          <form action="#" class="form-main mb-1">
              <fieldset>
                  <input type="text" placeholder="Пошук">
              </fieldset>
          </form>
          @if(empty($items) || count($items) < 1)
              <p>Немає єлементів</p>
          @else
              <ul class="aside-bar__list">
                  @foreach($items as $item)
                      <li>
                          <p class="mb-1">
                              <a href="{{ route($item['url']) }}">{{ $item['title'] }}</a>
                          </p>
                      </li>
                  @endforeach
              </ul>
          @endif
      </div>
  </aside>
  <div class="dashboard-panel">

  </div>
</div>
@endsection
