@extends('layout')

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper first-screen">
                <div class="full">
                    <ul class="breadcrumbs list">
                        <li>
                            <a href="{{ getLink(app()->getLocale()) }}">{{ __('base.home') }}</a>
                        </li>
                        @if(!empty($category))
                            <li>
                                <a href="{{ getLink(app()->getLocale()) }}">{{ __('base.home') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="full first-screen">
                    <h1 class="title-main full">{{ $product->title }}</h1>
                    @if(!empty($product->description))
                        <p>{{$product->description}}</p>
                    @endif
                </div>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
