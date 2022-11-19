<footer class="footer">
    <div class="wrapper f-left v-top">
        <div class="flex">
            <div class="one-of-four">
                <div class="logo mb-1">
                    {!! getLogo() !!}
                </div>
                <p>Wakizashi (c) - 2022</p>
            </div>
            <div class="one-of-four">
                <ul>
                    @foreach(getPages() as $fooPage)
                        <li>
                            <a href="{{ getlink( app()->getLocale() . '/' . $fooPage->alias) }}">{{ $fooPage->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="one-of-four">
                <ul class="list-two-items list">
                    @foreach(getCategories() as $navCategory)
                        <li>
                            <a href="{{ getLink(app()->getLocale() . '/category/' . $navCategory->alias) }}">{{ $navCategory->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="one-of-four">
                <ul>
                    <li>
                        <span>10:00 - 22:00</span>
                    </li>

                    <li>
                        <a href="tel:0123456789">+380 12 345 67 89</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex f-center">
            <a href="https://ucompany.site/en" target="_blank" class="text-center">
                <div class="copyrights__me flex f-center v-center mb-1">
                    <span>Developed with &#128151; by </span>
                    <img src="/dist/img/vp.svg" alt="Vlad Panov logo">
                </div>
                <p class="notice">2022</p>
            </a>
        </div>
    </div>
</footer>

<!-- Modals -->
<div class="cart-success">
    <div class="content">
        {{ __('cart.cart.success') }}
    </div>
</div>
