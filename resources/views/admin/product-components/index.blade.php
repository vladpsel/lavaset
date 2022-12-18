@extends('admin.layout')

@section('title', 'Створити компонент | Lavaset')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
    <div class="admin-aside__bar">
        <x-search-panel :items="$items" route="admin.components.single"></x-search-panel>
    </div>
  </aside>
  <div class="dashboard-panel">
      <div class="dashboard-panel">
          @if(session('message'))
              <div class="full message-notification">
                  {!! session('message') !!}
              </div>
          @endif
    <form class="form-main" action="#" method="post" enctype="multipart/form-data">
      @csrf

      <div class="flex f-between v-center">
        <h1 class="title-main item mb-1">Компоненти</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main primary">Створити новий</button>
        </div>
      </div>

      <div class="flex">

          <fieldset class="one-of-three">
              <label class="label">Назва</label>
              <input type="text" name="title" value="{{ request()->input('title', old('title')) }}" required>
              @error('title')
              <p class="notice mb-1 full error"> {{ $message }} </p>
              @enderror
          </fieldset>

          <fieldset class="one-of-three">
              <label class="label">Іконка</label>
              <input type="file" name="picture">
          </fieldset>

          <fieldset class="one-of-three">
              <label class="label">Порядковий номер</label>
              <input type="number" name="sort_order" value="{{ $sort_number }}" min="1">
          </fieldset>
          @error('sort_order')
          <p class="notice mb-1 full error"> {{ $message }} </p>
          @enderror
      </div>

    </form>
  </div>
</div>
@endsection
