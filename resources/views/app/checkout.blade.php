@extends('layout')

@section('content')
  @include('app.partials._header')
    <main>
        <section>
            <div class="wrapper first-screen">
                <div class="full">
                    <h1 class="title mb-1">Оформити замовлення</h1>
                </div>
                <form action="#" method="post" class="form-main flex">
                    @csrf

                    <div class="one-of-three">
                        <div class="cart-info mb-22">
                            <fieldset class="full">
                                <label>
                                    <span class="label">{{ __('cart.checkout.name') }}</span>
                                    <input type="text" name="name" value="{{ request()->input('name', old('name'))}}" autocomplete="username">
                                </label>
                                @error('name')
                                <p class="form-error"> {{ $message }} </p>
                                @enderror
                            </fieldset>

                            <fieldset class="full">
                                <label>
                                    <span class="label">{{ __('cart.checkout.phone') }}</span>
                                    <input type="tel" name="phone" value="{{ request()->input('phone', old('phone')) }}" placeholder="" autocomplete="tel" class="phone-input">
                                </label>
                                @error('phone')
                                <p class="form-error"> {{ $message }} </p>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="cart-details flex np">
                            <h3 class="subtitle full mb-1"> {{ __('cart.checkout.details') }}</h3>

                            <fieldset class="radio-wrp two-of-four">
                                <label>
                                    <input type="radio" name="details[type]" value="delivery" checked>
                                    <span class="check-label">{{ __('cart.checkout.delivery') }}</span>
                                </label>
                            </fieldset>

                            <fieldset class="radio-wrp two-of-four">
                                <label>
                                    <input type="radio" name="details[type]" value="pickup">
                                    <span class="check-label">{{ __('cart.checkout.pickup') }}</span>
                                </label>
                            </fieldset>

                            <div class="adress-info flex">
                                <fieldset class="full">
                                    <span class="label">{{ __('cart.checkout.street') }}</span>
                                    <input type="text" name="details[street]" value="{{ request()->input('details[street]', old('details[street]')) }}">
                                </fieldset>

                                <fieldset class="two-of-four">
                                    <span class="label">{{ __('cart.checkout.house') }}</span>
                                    <input type="text" name="details[building]" value="{{ request()->input('details[house]', old('details[house]')) }}">
                                </fieldset>

                                <fieldset class="two-of-four">
                                    <span class="label">{{ __('cart.checkout.entrance') }}</span>
                                    <input type="text" name="details[porch]" value="{{ request()->input('details[entrance]', old('details[entrance]')) }}">
                                </fieldset>

                                <fieldset class="one-of-three">
                                    <span class="label">{{ __('cart.checkout.pavilion') }}</span>
                                    <input type="text" name="details[pavilion]" value="{{ request()->input('details[pavilion]', old('details[pavilion]')) }}">
                                </fieldset>

                                <fieldset class="one-of-three">
                                    <span class="label">{{ __('cart.checkout.floor') }}</span>
                                    <input type="text" name="details[floor]" value="{{ request()->input('details[floor]', old('details[floor]')) }}">
                                </fieldset>

                                <fieldset class="one-of-three">
                                    <span class="label">{{ __('cart.checkout.flat') }}</span>
                                    <input type="text" name="details[flat]" value="{{ request()->input('details[flat]', old('details[flat]')) }}">
                                </fieldset>
                            </div>

                            <fieldset class="full">
                                <span class="label">{{ __('cart.checkout.comments') }}</span>
                                <textarea name="comment" cols="30" rows="10" placeholder="{{ __('cart.checkout.comments.placeholder') }}">{{ request()->input('comment', old('comment')) }}</textarea>
                            </fieldset>

                            <fieldset class="full">
                                <label class="check-wrp">
                                    <input type="checkbox" name="agreement" value="approved" checked required>
                                    <span class="checkmark"></span>
                                    <span class="check-title">{{ __('cart.checkout.policy') }}</span>
                                </label>
                                @error('agreement')
                                <p class="form-error"> {{ $message }} </p>
                                @enderror
                            </fieldset>

                            <fieldset class="full">
                                <button type="submit" name="submit" class="btn primary full">{{ __('cart.checkout.submit') }}</button>
                            </fieldset>

                        </div>
                    </div>

                    <div class="two-of-three">
                        <ul class="cart-product-list">

                            @foreach($products as $product)
                                <li class="flex v-center">
                                    <div class="img-wrp one-of-four mx-w">
                                        <a href="{{ route('public.product', [app()->getLocale(), $product->alias] ) }}" class="img-wrp">
                                            <img src="/upload/product/{{ $product->picture }}" alt="">
                                        </a>
                                    </div>
                                    <div class="two-of-three">
                                        <div class="flex np f-between mb-1">
                                            <h2 class="text item">{{ $product->title }}</h2>
                                            <button type="submit" name="remove" value="{{ $product->group }}" class="icon">
                                                <img src="/dist/img/icons/close.svg" alt="remove icon">
                                            </button>
                                        </div>
                                        <div class="flex v-center f-between m-no-wrp">
                                            <div class="count-input item">
                                                <input type="number" value="{{ $cartProducts[$product->group] }}" data-product="{{ $product->group }}" min="1">
                                                <span>{{ __('base.items') }}</span>
                                            </div>
                                            <p class="price text-right item">{{ $product->price . ' ' .__('base.currency') }} </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                        <div class="flex v-center f-between">
                            <p class="title item">{{ __('base.cart.total') }}:</p>
                            <p class="title item"> <span id="total-price">{{ $total }}</span> {{ __('base.currency') }}</p>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </main>
    @include('app.partials._footer')
@endsection
