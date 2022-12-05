@extends('layout')

@section('title', $product->title . ' | ' . getTitle())

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper first-screen">
                <div class="full mb-1">
                    <ul class="breadcrumbs list">
                        <li>
                            <a href="{{ getLink(app()->getLocale()) }}">{{ __('base.home') }}</a>
                        </li>
                        @if(!empty($category))
                            <li>
                                <a href="{{ getLink(app()->getLocale() . '/category/' . $category->alias) }}">{{ $category->title }}</a>
                            </li>
                        @endif
                        <li>
                            <span>{{ $product->title }}</span>
                        </li>
                    </ul>
                </div>
                <div class="product flex">
                    @if(!empty($product->picture))
                        <div class="one-of-three">
                            <div class="img-wrp">
                                <img src="/upload/product/{{ $product->picture }}" alt="{{ $product->title }} picture">
                            </div>
                        </div>
                    @endif
                    <div class="product-item two-of-three">
                        <div class="card">
                            <h1 class="title mb-1">{{ $product->title }}</h1>
                            <ul class="components-list flex mb-24">
                                @php
                                    $product->components = json_decode($product->components);
                                @endphp
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
                        <ul class="two-of-four">
                            @if(!empty($previous))
                            <li>
                                <a href="{{ route('public.product', ['locale' => app()->getLocale(), 'id' => $previous->alias]) }}" class="card flex">
                                    <p class="full np">{{ __('base.prev.item') }}:</p>
                                    <p class="subtitle">{{$previous->title}}</p>
                                </a>
                            </li>
                            @endif

                            @if(!empty($next))
                                    <li>
                                        <a href="{{ route('public.product', ['locale' => app()->getLocale(), 'id' => $next->alias]) }}" class="card flex">
                                            <p class="full np">{{ __('base.next.item') }}:</p>
                                            <p class="subtitle">{{$next->title}}</p>
                                        </a>
                                    </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="wrapper">
                <div class="full mb-1">
                    <h2 class="title full">{{ __('base.get_recommended') }}</h2>
                </div>
                <ul class="products-list full list-four-items list flex mx-w">
                    @if(!empty($recommended) && count($recommended) >= 1)
                        @foreach($recommended as $single)
                            @php
                                $single['components'] = json_decode($single['components']);
                            @endphp
                            <li>
                                <div class="card">
                                    @if(!empty($single['picture']))
                                        <a href="{{ route('public.product', ['locale' => app()->getLocale(), 'id' => $single['alias']]) }}" class="img-wrp">
                                            <img src="/upload/product/{{ $single['picture'] }}" alt="">
                                        </a>
                                    @endif
                                    <a href="{{ route('public.product', ['locale' => app()->getLocale(), 'id' => $single['alias']]) }}" class="product-title mb-18">{{ $single['title'] }}</a>
                                    <ul class="components-list flex mb-24">
                                        @foreach($components as $component)
                                            @if(!empty($single['components']) && in_array($component->group, $single['components']))
                                                <li>{{ $component->title }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <p class="colored">{{ $single['weight'] }} {{ $product::getWeightIndicator($single['parameter']) }}</p>
                                    <p class="price text-right mb-22">{{ $single['price'] . ' ' .__('base.currency') }} </p>
                                    <button type="button" name="button" class="buy-btn btn primary" data-id="{{ $single['group'] }}">{{ __('base.buy.btn') }}</button>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
