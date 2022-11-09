@extends('admin.layout')

@section('title', 'Замовлення | Lavaset')

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
                            <a href="#">{{ $item->name }}</a>
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
      <div class="dashboard-panel">
          @if(session('message'))
              <div class="full message-notification">
                  {!! session('message') !!}
              </div>
          @endif
    <form class="form-main" action="#" method="post" enctype="multipart/form-data">
      @csrf

      <div class="flex f-between v-center">
        <h1 class="title-main item mb-1">Нове замовлення</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main primary">Створити</button>
        </div>
      </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ dump($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      <div class="flex">
          <div class="one-of-three">
              <fieldset>
                  <label class="label">Ім'я</label>
                  <input type="text" name="name" value="{{ request()->input('name', old('name')) }}" required>
                  @error('name')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>
              <fieldset>
                  <label class="label">Телефон</label>
                  <input type="tel" name="phone" value="{{ request()->input('phone', old('phone')) }}" required>
                  @error('phone')
                  <p class="notice mb-1 full error"> {{ $message }} </p>
                  @enderror
              </fieldset>
              <fieldset>
                  <label class="label">Статус замовлення</label>
                  <select name="status">
                      @foreach($conditions as $key => $condition)
                          <option value="{{ $key }}" @if($key === 'new') selected @endif>{{ $condition }}</option>
                      @endforeach
                  </select>
              </fieldset>
              <h3 class="subtitle mb-1">Деталі</h3>
              <fieldset>
                  <label class="label">Тип доставки</label>
                  <select name="details['type']">
                      <option value="delivery">Доставка</option>
                      <option value="pickup">Самовивіз</option>
                  </select>
              </fieldset>
              <fieldset>
                  <label class="label">Вулиця</label>
                  <input type="text" name="details['street']">
              </fieldset>
              <fieldset>
                  <label class="label">Дім</label>
                  <input type="text" name="details['building']">
              </fieldset>
              <fieldset>
                  <label class="label">Під'їзд</label>
                  <input type="text" name="details['porch']">
              </fieldset>
              <fieldset>
                  <label class="label">Корпус</label>
                  <input type="text" name="details['pavilion']">
              </fieldset>
              <fieldset>
                  <label class="label">Поверх</label>
                  <input type="text" name="details['floor']">
              </fieldset>
              <fieldset>
                  <label class="label">Квартира</label>
                  <input type="text" name="details['flat']">
              </fieldset>
              <fieldset>
                  <label class="label">Коментар</label>
                  <textarea name="comment" cols="30" rows="10">{{ request()->input('comment', old('comment')) }}</textarea>
              </fieldset>
          </div>
          <div class="two-of-three">
              <fieldset>
                  <label class="label">Загальна вартість</label>
                  <input type="number" name="total" id="total" readonly>
              </fieldset>
              <h3 class="subtitle">Товари</h3>
              <ul class="products-list component-list">
                  @foreach($products as $product)
                      <li>
                          <label class="two-of-four">
                              <input type="checkbox" name="products[{{ $product->group }}]" value="1" data-product-id="{{ $product->group }}">
                              <span class="checkmark"></span>
                              <span class="check-label">{{ $product->title }}</span>
                          </label>
                          <div class="two-of-four flex f-right v-center">
                              <fieldset class="item">
                                  <input type="number" data-product-quantity="{{ $product->group }}" value="1" min="1">
                              </fieldset>
                              <p class="item">
                                  <span data-price-id="{{ $product->group }}">{{ $product->price }}</span> uah.
                              </p>
                          </div>
                      </li>
                  @endforeach
              </ul>
          </div>
      </div>

    </form>
  </div>
</div>
@endsection
