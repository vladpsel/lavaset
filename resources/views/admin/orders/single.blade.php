@extends('admin.layout')

@section('title', 'Замовлення ' . $order->id . ' | Lavaset')

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
                            <a href="{{route('admin.orders.single', $item->id)}}">{{ $item->id . '. ' . $item->name }}</a>
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

          <div class="flex f-between v-center">
              <h1 class="title-main item mb-1">Замовлення: #{{ $order->id }}</h1>
              <div class="btn-group item mb-1">
                  <a href="{{ route('admin.orders.single.edit', $order->id) }}" class="btn btn-main primary">Редагувати</a>
              </div>
          </div>
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                   </ul>
              </div>
          @endif

      <div class="flex">
          <div class="one-of-three">
              <ul class="user-data-list mb-1">

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Ім'я: </span>
                          <span>{{ $order->name }}</span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Телефон: </span>
                          <span>{{ $order->phone }}</span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Статус замовлення: </span>
                          <span>
                              @foreach($conditions as $key => $condition)
                                  @if($key === $order->status) {{ $condition }} @endif
                              @endforeach
                          </span>
                      </p>
                  </li>
              </ul>
              <h3 class="subtitle mb-1">Деталі</h3>
              <ul class="user-data-list mb-1">

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Тип доставки: </span>
                          <span>
                              @if($order->details['type'] === 'delivery') Доставка @endif
                                  @if($order->details['type'] === 'pickup') Самовивіз @endif
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Вулиця: </span>
                          <span>
                              {{ $order->details['street'] }}
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Дім: </span>
                          <span>
                              {{ $order->details['building'] }}
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Під'їзд: </span>
                          <span>
                              {{ $order->details['porch'] }}
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Корпус: </span>
                          <span>
                              {{ $order->details['pavilion'] }}
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Поверх: </span>
                          <span>
                              {{ $order->details['floor'] }}
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Квартира: </span>
                          <span>
                              {{ $order->details['flat'] }}
                          </span>
                      </p>
                  </li>

                  <li class="mb-1">
                      <p>
                          <span class="notice bold">Коментар: </span>
                          <span>
                              {{ $order->comment }}
                          </span>
                      </p>
                  </li>


              </ul>
          </div>
          <div class="two-of-three">
              <div class="flex mb-1">
                  <span class="item">Загальна сума:</span>
                  <span class="item">{{ $order->total }}</span>
              </div>
              <h3 class="subtitle mb-1">Товари</h3>
              <ul class="products-list">
                  @foreach($order->products as $product)
                      <li class="flex">
                          <span class="two-of-four">{{ $product['title'] }}</span>
                          <span class="one-of-four">{{ $product['quantity'] }} шт.</span>
                          <span class="one-of-four">{{ $product['price'] }} грн.</span>
                      </li>
                  @endforeach
              </ul>
          </div>
      </div>
  </div>
</div>
@endsection
