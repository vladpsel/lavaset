@extends('admin.layout')

@section('title', 'Оновити категорію: ' . $category->title . ' | Lavaset')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
    <div class="admin-aside__bar">
        <x-search-panel :items="$items" route="admin.categories.single"></x-search-panel>
    </div>
  </aside>
  <div class="dashboard-panel">
      @if(session('message'))
          <div class="full message-notification">
              {!! session('message') !!}
          </div>
      @endif
    <form class="form-main" action="#" method="post" enctype="multipart/form-data">
      @csrf

      <div class="flex f-between v-center">
        <h1 class="title-main item mb-1">Оновити категорію: {{ $category->title }}</h1>
        <div class="btn-group item mb-1">
          <a href="{{ route('admin.categories.single.delete', $category->group) }}" class="btn btn-main alert">Видалити</a>
          <button type="submit" name="submit" class="btn btn-main primary">Оновити</button>
        </div>
      </div>

      <div class="flex">

          <fieldset class="two-of-four">
              <label class="label">Назва</label>
              <input type="text" name="title" value="{{ request()->input('title', $category->title) }}" required>
              @error('title')
              <p class="notice mb-1 full error"> {{ $message }} </p>
              @enderror
          </fieldset>

          <fieldset class="two-of-four">
              <label class="label">Аліас</label>
              <input type="text" name="alias" value="{{ request()->input('alias', $category->alias) }}" class="translit-input" required>
              @error('alias')
              <p class="notice mb-1 full error"> {{ $message }} </p>
              @enderror
          </fieldset>

          <p class="notice mb-1 full">
              Аліас - це url сторінки (унікальний ID). Наприклад: site.com/<span class="bold">alias</span>.
              Аліас необхідно заповнювати латинськими літерами, низьким регістром, замість пробілу використовувати "-"
          </p>

          <fieldset class="one-of-three">
              <label class="label">Иконка: <span class="notice"> {{ $category->icon }} </span></label>
              <div class="img-wrp mb-1">
                  <img src="/upload/categories/{{ $category->icon }}" alt="">
              </div>
              <a href="{{ route('admin.remove.asset', ['categories', $category->icon]) }}" class="flex error mb-1">Очистити зображення</a>
              <input type="file" name="icon">
          </fieldset>


          <fieldset class="one-of-three">
              <label class="label">Опис</label>
              <textarea name="description" rows="8" cols="80">{{ request()->input('description', $category->description) }}</textarea>
          </fieldset>
          @error('description')
          <p class="notice mb-1 full error"> {{ $message }} </p>
          @enderror

          <fieldset class="one-of-three">
              <label class="label">Ключові слова</label>
              <textarea name="keywords" rows="8" cols="80">{{ request()->input('keywords', $category->keywords) }}</textarea>
              @error('keywords')
              <p class="notice mb-1 full error"> {{ $message }} </p>
              @enderror
          </fieldset>
      </div>


      </div>

    </form>
  </div>
</div>
@endsection
