@extends('layout')

@section('title', getTitle())

@section('content')
  @include('app.partials._header')
    <main>

        @if(!empty($title))
        <section>
          <div class="wrapper first-screen">
            <div class="full mb-1">
              <div class="two-of-three mx-w mb-1">
                  <h2 class="title mb-1">{{ $title['title'] }}</h2>
                  <p>
                      {{ $title['text'] }}
                  </p>
              </div>
                <ul class="full">
                    @foreach($content as $paragraph)
                        <li class="mb-1">
                            <p class="subtitle mb-1">{{ $paragraph['title'] }}</p>
                            <p>{!! $paragraph['text'] !!}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

          </div>
        </section>
        @endif

    </main>
    @include('app.partials._footer')
@endsection
