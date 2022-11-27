@extends('admin.layout')

@section('title', 'Створити товар | Lavaset')

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
                        <p class="mb-1">{{ $item[0]->title  }}</p>
                        <ul class="list">
                            @foreach($item as $singleItem)
                                <li>
                                    <a href="{{ route('admin.products.single', $singleItem->id) }}" class="lang-item">{{ $singleItem->locale }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        @endif
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
        <h1 class="title-main item mb-1">Товар</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main primary">Створити новий</button>
        </div>
      </div>

      <div class="flex">

          <div class="one-of-three">
              <fieldset>
                  <label class="label">Зображення</label>
                  <input type="file" name="picture">
              </fieldset>
              <fieldset>
                  <label class="label">Категорія</label>
                  <select name="category_id">
                      <option value="0" selected>Без категорії</option>
                      @foreach($categories as $category)
                          <option value="{{ $category->group }}">{{ $category->title }}</option>
                      @endforeach
                  </select>
                  @error('category_id')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>
              <fieldset>
                  <label class="label">Порядковий номер</label>
                  <input type="number" name="sort_order" value="{{ $sort_order }}">
              </fieldset>
              <h3 class="subtitle mb-1">Компоненти</h3>
              <ul class="component-list">
                  @foreach($components as $component)
                      <li>
                          <label>
                              <input type="checkbox" name="components[]" value="{{ $component->group }}">
                              <span class="checkmark"></span>
                              <span class="check-label">{{ $component->title }}</span>
                          </label>
                      </li>
                  @endforeach
              </ul>

          </div>

          <div class="flex two-of-three">
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
                  Аліас - це url сторінки (унікальний ID). Наприклад: site.com/category/<span class="bold">alias</span>.
                  Аліас необхідно заповнювати латинськими літерами, низьким регістром, замість пробілу використовувати "-"
              </p>

              <fieldset class="full">
                  <label class="label">Опис</label>
                  <textarea name="description" cols="30" rows="10">{{ request()->input('description', old('description')) }}</textarea>
                  @error('parameter')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>

              <fieldset class="one-of-four">
                  <label class="label">Ціна</label>
                  <input type="number" name="price" value="{{ request()->input('price', old('price')) }}" step="0.01" min="0.01" required>
                  @error('price')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>

              <fieldset class="one-of-four">
                  <label class="label">Вага</label>
                  <input type="number" name="weight" value="{{ request()->input('weight', old('weight')) }}">
                  @error('weight')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>

              <fieldset class="one-of-four">
                  <label class="label">Од. вимірювання</label>
                  <select name="parameter">
                      @foreach($indicators as $id => $indicator)
                          <option value="{{ $id }}"> {{ $indicator }}</option>
                      @endforeach
                  </select>
                  @error('parameter')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>

          </div>

      </div>

    </form>
  </div>
</div>
@endsection
