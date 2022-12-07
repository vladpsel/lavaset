@extends('admin.layout')

@section('title', 'Редагувати компонент ' . $component->title . ' | Lavaset')

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
        <h1 class="title-main item mb-1">Компонент </h1>
        <div class="btn-group item mb-1">
            <a href="{{ route('admin.components.single.delete', $component->group) }}" class="btn btn-main alert">Видалити</a>
            <button type="submit" name="submit" class="btn btn-main primary">Оновити</button>
        </div>
      </div>

      <div class="flex">

          <fieldset class="one-of-four">
              <label class="label">Назва</label>
              <input type="text" name="title" value="{{ request()->input('title', $component->title) }}" required>
              @error('title')
              <p class="notice mb-1 full error"> {{ $message }} </p>
              @enderror
          </fieldset>

          <fieldset class="one-of-four">
              <label class="label">Іконка: <span class="notice">{{ $component->picture }}</span> </label>
              <input type="file" name="icon">
              <div class="img-wrp mb-1">
                  <img src="/upload/components/{{ $component->picture }}" alt="#">
              </div>
              <a href="{{ route('admin.remove.asset', ['components', $component->picture]) }}" class="flex error mb-1">Очистити зображення</a>
          </fieldset>

          <fieldset class="one-of-four">
              <label class="label">Порядковий номер</label>
              <input type="number" name="sort_order" value="{{ $component->sort_order }}" min="1">
          </fieldset>
          @error('sort_order')
          <p class="notice mb-1 full error"> {{ $message }} </p>
          @enderror

          <fieldset class="one-of-four">
              <label class="label">Видимість на сайті</label>
              <select name="isVisible">
                  <option value="0" @if($component->isVisible == '0') selected @endif >Приховано</option>
                  <option value="1" @if($component->isVisible == '1') selected @endif >На сайті</option>
              </select>
          </fieldset>
      </div>
    </form>
  </div>
</div>
@endsection
