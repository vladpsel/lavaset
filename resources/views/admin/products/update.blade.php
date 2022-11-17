@extends('admin.layout')

@section('title', 'Оновити товар ' . $entity->title . ' | Lavaset')

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
        <h1 class="title-main item mb-1">Товар: {{ $entity->title }}</h1>
        <div class="btn-group item mb-1">
            <a href="{{ route('admin.products.single.delete', $entity->group) }}" class="btn btn-main alert">Видалити</a>
          <button type="submit" name="submit" class="btn btn-main primary">Оновити</button>
        </div>
      </div>

      <div class="flex">

          <div class="one-of-three">
              <fieldset>
                  <label class="label">Видимість на сайті</label>
                  <select name="is_visible">
                      <option value="0" @if($entity->is_visible == '0') selected @endif>Приховано</option>
                      <option value="1" @if($entity->is_visible == '1') selected @endif>На сайті</option>
                  </select>
              </fieldset>
              <fieldset>
                  <label class="label">Зображення: <span class="notice">{{ $entity->picture }}</span> </label>
                  @if(!empty($entity->picture))
                      <button type="submit" name="remove_pic" class="flex error mb-1">Видалити зображення</button>
                  @endif

                  <input type="file" name="picture">
              </fieldset>
              <fieldset>
                  <label class="label">Категорія</label>
                  <select name="category_id">
                      <option value="null" @if(empty($entity->category_id)) selected @endif>Без категорії</option>
                      @foreach($categories as $category)
                          <option value="{{ $category->group }}" @if($entity->category_id === $category->group) selected @endif>{{ $category->title }}</option>
                      @endforeach
                  </select>
              </fieldset>
              <fieldset>
                  <label class="label">Порядковий номер</label>
                  <input type="number" name="sort_order" value="{{ request()->input('sort_order', $entity->sort_order) }}">
              </fieldset>
              <h3 class="subtitle mb-1">Компоненти</h3>
              <ul class="component-list">
                  @foreach($components as $component)
                      <li>
                          <label>
                              <input type="checkbox" name="components[]" value="{{ $component->group }}"
                                     @if(in_array($component->group, $itemComponents)) checked @endif
                              >
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
                  <input type="text" name="title" value="{{ request()->input('title', $entity->title) }}" required>
              </fieldset>
              <fieldset class="two-of-four">
                  <label class="label">Аліас</label>
                  <input type="text" name="alias" value="{{ request()->input('alias', $entity->alias) }}" class="translit-input" required>
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
                  <textarea name="description" cols="30" rows="10">{{ request()->input('description', $entity->description) }}</textarea>
              </fieldset>

              <fieldset class="one-of-four">
                  <label class="label">Ціна</label>
                  <input type="number" name="price" value="{{ request()->input('price', $entity->price) }}" step="0.01" min="0.01" required>
              </fieldset>

              <fieldset class="one-of-four">
                  <label class="label">Вага</label>
                  <input type="number" name="weight" value="{{ request()->input('weight', $entity->weight) }}">
              </fieldset>

              <fieldset class="one-of-four">
                  <label class="label">Од. вимірювання</label>
                  <select name="parameter">
                      @foreach($indicators as $id => $indicator)
                          <option value="{{ $id }}" @if($entity->parameter === $id) selected @endif> {{ $indicator }}</option>
                      @endforeach
                  </select>
              </fieldset>

          </div>

      </div>

    </form>
  </div>
</div>
@endsection
