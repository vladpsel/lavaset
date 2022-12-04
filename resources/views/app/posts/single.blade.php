@extends('layout')

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper first-screen">
                <div class="full">
                    <h1 class="title mb-1">{{ $post->title }}</h1>
                    @if(!empty($post->picture) && $post->picture != '')
                        <div class="img-wrp mb-1">
                            <img src="/upload/posts/{{ $post->picture }}" alt="{{ $post->picture }}">
                        </div>
                    @endif
                    @if(!empty($post->text) && $post->text != '')
                        <p class="mb-1">
                            {{ $post->text }}
                        </p>
                    @endif
                </div>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
