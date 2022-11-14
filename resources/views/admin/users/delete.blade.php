@extends('admin.layout')

@section('title', 'Видалити сторінку - | Lavaset')

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
      @if(count($items) < 1)
          <p>Немає єлементів</p>
        @else
            <ul class="aside-bar__list">
                @foreach($items as $item)
                    <li>
                        <p class="mb-1">
                            <a href="#">{{ $item->id . '. ' . $item->name }}</a>
                        </p>
                        <p>
                            <a href="#">{{ $item->phone }}</a>
                        </p>
                    </li>
                @endforeach
            </ul>
      @endif


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
        <h1 class="title-main item mb-1">Видалити користувача {{ $user->name }} з id {{ $user->email }}</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main alert">Так</button>
        </div>
          <p class="full">Будьте уважні! Після видалення ви не зможете повернути дані. Ця операція є невідворотною!</p>
      </div>

    </form>
  </div>
</div>
@endsection
