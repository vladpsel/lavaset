@extends('admin.layout')

@section('title', 'Login')

@section('content')
<section>
  <div class="wrapper full-height f-center v-center">
    <form class="form-main one-of-four mx-w" action="#" method="post">
      @csrf

      <div class="text-center">
          <img src="/dist/img/lavaset.svg" alt="">
      </div>

      <fieldset>
        <label class="label">Логін</label>
        <input type="text" name="email" value="{{ request()->input('email', old('email')) }}" placeholder="admin@admin.com" min="6" autocomplete="email" required>
      </fieldset>
        @error('email')
        <p class="error mb-1">{{ $message }}</p>
        @enderror
      <fieldset>
        <label class="label">Пароль</label>
        <input type="password" name="password" placeholder="password" value="" autocomplete="current-password" required>
      </fieldset>
        @error('password')
        <p class="error mb-1">{{ $message }}</p>
        @enderror
      <fieldset>
        <button type="submit" name="submit" class="btn btn-main primary full">Увійти</button>
      </fieldset>
        @error('login')
        <p class="error mb-1">{{ $message }}</p>
        @enderror

    </form>
  </div>
</section>
@endsection
