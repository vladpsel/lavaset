@extends('admin.layout')

@section('title', 'Створити сторінку | Lavaset')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
    <div class="admin-aside__bar">
      <x-search-panel :items="$pages" route="admin.pages.single"></x-search-panel>
    </div>

  </aside>
  <div class="dashboard-panel">
    <form class="form-main" action="#" method="post">
      @csrf

      <div class="flex f-between v-center">
        <h1 class="title-main item mb-1">Cторінка</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main primary">Створити нову</button>
        </div>
      </div>

      <div class="flex">
        <fieldset class="two-of-four">
          <label class="label">Назва</label>
          <input type="text" name="title" value="{{ request()->input('title', old('title')) }}" required>
            @error('title')
            <p class="notice mb-1 full error"> {{ $message }} </p>
            @enderror
        </fieldset>

        <fieldset class="two-of-four">
          <label class="label">Аліас</label>
          <input type="text" name="alias" value="{{ request()->input('alias', old('alias')) }}" class="translit-input" required>
            @error('alias')
            <p class="notice mb-1 full error"> {{ $message }} </p>
            @enderror
        </fieldset>


        <p class="notice mb-1 full">
            Аліас - це url сторінки (унікальний ID). Наприклад: site.com/<span class="bold">alias</span>.
            Аліас необхідно заповнювати латинськими літерами, низьким регістром, замість пробілу використовувати "-"
        </p>

        <fieldset class="two-of-four">
          <label class="label">Опис</label>
          <textarea name="description" rows="8" cols="80">{{ request()->input('description', old('description')) }}</textarea>
        </fieldset>
          @error('description')
          <p class="notice mb-1 full error"> {{ $message }} </p>
          @enderror

        <fieldset class="two-of-four">
          <label class="label">Ключові слова</label>
          <textarea name="keywords" rows="8" cols="80">{{ request()->input('keywords', old('keywords')) }}</textarea>
        </fieldset>
      </div>

    </form>
  </div>
</div>
@endsection
