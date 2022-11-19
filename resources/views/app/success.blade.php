@extends('layout')

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper first-screen">
                <div class="full">
                    <h1 class="title mb-1">{{ __('base.thank-you') }}</h1>
                    <p class="mb-1">{{ __('base.thank-you-text') }}</p>
                    <a href="{{ getLink(app()->getLocale()) }}" class="btn primary">{{ __('base.home') }}</a>
                </div>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
