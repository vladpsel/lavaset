@extends('layout')

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper">
                <div class="full first-screen">
                    <h1 class="title-main full">{{ $category->title }}</h1>
                    @if(!empty($category->description))
                        <p>{{$category->description}}</p>
                    @endif
                </div>
                <ul class="products-list list-four-items list flex mx-w np">
                    @if(!empty($products) && count($products) >= 1)
                        @foreach($products as $product)
                            @php
                                $product->components = json_decode($product->components);
                            @endphp
                            <li>
                                <div class="card">
                                    <a href="#" class="img-wrp">
                                        <img src="/upload/product/{{ $product->picture }}" alt="">
                                    </a>
                                    <a href="#" class="product-title mb-18">{{ $product->title }}</a>
                                    <ul class="components-list flex mb-24">
                                        @foreach($components as $component)
                                            @if(!empty($product->components) && in_array($component->group, $product->components))
                                                <li>{{ $component->title }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <p class="colored">{{ $product->weight }} {{ $product::getWeightIndicator($product->parameter) }}</p>
                                    <p class="price text-right mb-22">{{ $product->price . ' ' .__('base.currency') }} </p>
                                    <button type="button" name="button" class="buy-btn btn primary" data-id="{{ $product->group }}">{{ __('base.buy.btn') }}</button>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <p>{{ __('base.empty') }}</p>
                    @endif
                </ul>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
