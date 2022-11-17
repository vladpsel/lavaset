@extends('layout')

@section('content')
  @include('app.partials._header')
    <main>
        <section class="home-greeting">
            <div class="bg img-wrp">
                <img src="/dist/img/papyrus.svg" alt="bg">
            </div>

            <div class="homepage-slider swiper">

                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                      <div class="content flex f-center">

                          <div class="img-left one-of-three mx-w img-wrp">
                              <img src="/dist/img/left.png" alt="">
                          </div>

                          <div class="wrapper f-center">
                              <div class="two-of-four mx-w text-center">
                                  <h2 class="title-main mb">Ну дуууууууже смачно</h2>
                                  <p>
                                      Найсмачніші суші для тебе і твоїх друзів! Спробуй і ти повертатимешся знов і знов!
                                  </p>
                                  <a href="#" class="btn btn-main primary">Детальніше</a>
                              </div>
                          </div>

                          <div class="img-right one-of-three mx-w img-wrp">
                              <img src="/dist/img/right.png" alt="">
                          </div>


                      </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="content flex f-center">

                            <div class="img-left one-of-three mx-w img-wrp">
                                <img src="/dist/img/left2.png" alt="">
                            </div>

                            <div class="wrapper f-center">
                                <div class="two-of-four mx-w text-center">
                                    <h2 class="title-main mb">Нові сети</h2>
                                    <p>
                                        Ми створили нові неповторні сети! Скуштуй страви які не залишать тебе байдужим
                                    </p>
                                    <a href="#" class="btn btn-main primary">Спробувати</a>
                                </div>
                            </div>

                            <div class="img-right one-of-three mx-w img-wrp">
                                <img src="/dist/img/right2.png" alt="">
                            </div>


                        </div>
                    </div>

                </div>

                <div class="swiper-pagination"></div>

                <div class="swiper-button-next"></div>


                <div class="swiper-scrollbar"></div>
            </div>
        </section>

        <section>
          <div class="wrapper">
            <div class="full mb-1">
              <div class="two-of-three mx-w np">
                  <h2 class="title mb-1">Настав час скуштувати найсмачніші суші!</h2>
                  <p>
                      Ми зібрали найпопулярніші позиції для того, щоб надати змогу якнайшвидке скуштувати ці шедеври.
                      Не знайшли щось для себе у запропонованих стравах, перейдіть у повний каталог категорії та стовідсотково знайдіть
                      для себе страву!
                  </p>
              </div>
            </div>
          </div>
        </section>

        @foreach($categories as $category)
            @php
                $productModel = new \App\Models\Product;
                $products = $productModel::getRandomProductsByCategory($category->group);
            @endphp
            @if(!empty($products))
            <section>
                <div class="wrapper">
                    <div class="flex full v-center f-between mb-1">
                        <h3 class="title item">{{ $category->title }}</h3>
                        <a href="{{ getLink(app()->getLocale() . '/category/' . $category->alias) }}" class="item btn">Дивитись всю категорію</a>
                    </div>
                    <ul class="products-list list-four-items list flex mx-w">
                        @foreach($products as $product)
                            @php
                                $product['components'] = json_decode($product['components']);
                            @endphp
                            <li>
                                <div class="card">
                                    <a href="#" class="img-wrp">
                                        <img src="/upload/product/{{ $product['picture'] }}" alt="">
                                    </a>
                                    <a href="#" class="product-title mb-18">{{ $product['title'] }}</a>
                                    <ul class="components-list flex mb-24">
                                        @foreach($components as $component)
                                            @if(!empty($product['components']) && in_array($component->group, $product['components']))
                                                <li>{{ $component->title }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <p class="colored">{{ $product['weight'] }} {{ $productModel::getWeightIndicator($product['parameter']) }}</p>
                                    <p class="price text-right mb-22">{{ $product['price'] . ' ' .__('base.currency') }} </p>
                                    <button type="button" name="button" class="buy-btn btn primary" data-id="{{ $product['group'] }}">В корзину</button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
            @endif
        @endforeach

    </main>
    @include('app.partials._footer')
@endsection
