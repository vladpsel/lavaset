@extends('layout')

@section('title', $title->title . ' | ' . getTitle())

@section('content')
  @include('app.partials._header')
    <main>
        @if(!empty($title))
        <section>
          <div class="wrapper first-screen">
            <div class="full mb-1">
              <div class="two-of-three mx-w">
                  <h2 class="title mb-1">{{ $title->title }}</h2>
                  <p>
                      {{ $title->text }}
                  </p>
              </div>
            </div>
            @if($items && !empty($items))
                <ul class="list-four-items list full">
                    @foreach($items as $key => $item)
                        <li>
                            <div class="box">
                                <p class="subtitle mb-1">{{ ++$key }}</p>
                                <p>{{ $item->text }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
          </div>
        </section>
        @endif

    </main>
    @include('app.partials._footer')
@endsection
