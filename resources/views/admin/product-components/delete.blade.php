@extends('admin.layout')

@section('title', 'Видалити компонент - ' .$requested[0]->title . ' | Lavaset')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
    <div class="admin-aside__bar">
        <x-search-panel :items="$items" route="admin.components.single"></x-search-panel>
    </div>
  </aside>
  <div class="dashboard-panel">
      @if(session('message'))
          <div class="full message-notification">
              {!! session('message') !!}
          </div>
      @endif
    <form class="form-main" action="#" method="post">
      @csrf

      <div class="flex f-between v-center">
        <h1 class="title-main item mb-1">Видалити компонент: {{ $requested[0]->title }}</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main alert">Так</button>
        </div>
          <p class="full">Будьте уважні! Після видалення цього компоненту ви не зможете повернути дані, також цей компонент буде не доступний у товарах. Ця операція є невідворотною!</p>
      </div>

    </form>
  </div>
</div>
@endsection
