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
      <ul class="aside-bar__list">
        @foreach($pages as $page)
        <li>
            <p class="mb-1">{{ $page[0]->title  }}</p>
            <ul class="list">
                @foreach($page as $singleItem)
                <li>
                    <a href="#" class="lang-item">{{ $singleItem->locale }}</a>
                </li>
                @endforeach
            </ul>
        </li>
        @endforeach
      </ul>
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
          <input type="text" name="title" value="" required>
        </fieldset>

        <fieldset class="two-of-four">
          <label class="label">Аліас</label>
          <input type="text" name="alias" value="" class="translit-input" required>
        </fieldset>

        <p class="notice mb-1 full">
            Аліас - це url сторінки (унікальний ID). Наприклад: site.com/<span class="bold">alias</span>.
            Аліас необхідно заповнювати латинськими літерами, низьким регістром, замість пробілу використовувати "-"
        </p>

        <fieldset class="two-of-four">
          <label class="label">Опис</label>
          <textarea name="description" rows="8" cols="80"></textarea>
        </fieldset>

        <fieldset class="two-of-four">
          <label class="label">Ключові слова</label>
          <textarea name="keywords" rows="8" cols="80"></textarea>
        </fieldset>
      </div>

    </form>
  </div>
</div>
@endsection
