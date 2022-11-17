<header class="header">

  <div class="header__top">
    <div class="wrapper v-center f-between">

      <div class="one-of-three">
          <nav>
              @foreach(getPages() as $navPage)
                  <a href="{{ getlink( app()->getLocale() . '/' . $navPage->alias) }}">{{ $navPage->title }}</a>
              @endforeach
          </nav>
      </div>

      <div class="logo">
          {!! getLogo() !!}
      </div>

      <div class="one-of-three flex f-right v-center">
        <ul class="icon-list list item">
          <li>
            <div class="icon">
              <img src="/dist/img/icons/clock.svg" alt="">
            </div>
            <span>10:00 - 22:00</span>
          </li>

          <li>
            <div class="icon">
              <img src="/dist/img/icons/call.svg" alt="">
            </div>
            <a href="tel:0123456789">+380 12 345 67 89</a>
          </li>

        </ul>

        <ul class="lang-list list">
            @foreach(getLangList() as $locale)
                <li>
                    <a href="/{{ $locale . '/' . \Illuminate\Support\Facades\Route::currentRouteName() }}">{{ ucfirst($locale) }}</a>
                </li>
            @endforeach
        </ul>
      </div>

    </div>
  </div>


  <div class="header__bot">
    <div class="wrapper f-center">
      <ul class="nav-list icon-list list flex f-center">
        @foreach(getCategories() as $navCategory)
          <li>
            <div class="icon">
              <img src="/upload/categories/{{ $navCategory->icon }}" alt="{{ $navCategory->title }} icon">
            </div>
            <a href="{{ getLink(app()->getLocale() . '/category/' . $navCategory->alias) }}">{{ $navCategory->title }}</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

</header>
