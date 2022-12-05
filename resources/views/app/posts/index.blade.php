@extends('layout')

@section('title', getTitle())

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper first-screen">
                <div class="full mb-1">
                    <h1 class="title">{{ __('base.posts-title') }}</h1>
                </div>
                <div class="full">
                    <div class="swiper news-slider">
                        <div class="swiper-wrapper">
                            @foreach($items as $item)
                                <div class="swiper-slide">
                                    @if(!empty($item->picture) && $item->picture != '')
                                        <div class="img-wrp mb-1">
                                            <img src="/upload/posts/{{ $item->picture }}" alt="{{ $item->picture }}">
                                        </div>
                                    @endif
                                    <h3 class="subtitle mb-1">
                                        {{ $item->title }}
                                    </h3>
                                    <p class="mb-1">
                                        {{ getCuttedText($item->text) }}
                                    </p>
                                    <a href="{{ getLink(app()->getLocale() . '/news/' . $item->alias) }}" class="btn-link btn f-right">{{ __('base.detail-btn') }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
