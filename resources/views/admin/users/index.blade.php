@extends('admin.layout')

@section('title', 'Замовлення | Lavaset')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
    <div class="admin-aside__bar">
      <form action="#" class="form-main mb-1">
          <fieldset>
              <input type="text" placeholder="Пошук">
          </fieldset>
      </form>

        @if(count($items) < 1)
            <p>Немає єлементів</p>
        @else
            <ul class="aside-bar__list">
                @foreach($items as $item)
                    <li>
                        <p class="mb-1">
                            <a href="{{ route('admin.users.single', $item->id) }}">{{ $item->id . '. ' . $item->name }}</a>
                        </p>
                        <p>
                            <a href="#">{{ $item->phone }}</a>
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif

    </div>
  </aside>
  <div class="dashboard-panel">
      <div class="dashboard-panel">
          @if(session('message'))
              <div class="full message-notification">
                  {!! session('message') !!}
              </div>
          @endif
    <form class="form-main" action="#" method="post" enctype="multipart/form-data">
      @csrf

      <div class="flex f-between v-center">
        <h1 class="title-main item mb-1">Створити користувача</h1>
        <div class="btn-group item mb-1">
          <button type="submit" name="submit" class="btn btn-main primary">Створити</button>
        </div>
      </div>
      <div class="full np">
        <div class="one-of-three mx-w">
          <fieldset>
            <label class="label">Ім'я</label>
            <input type="text" name="name" value="{{ request()->input('name', old('name')) }}" required>
          </fieldset>
          <fieldset>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ request()->input('email', old('email')) }}" required>
          </fieldset>
          <fieldset>
            <label class="label">Телефон</label>
            <input type="tel" name="phone" value="{{ request()->input('phone', old('phone')) }}">
          </fieldset>
          <fieldset>
            <label class="label">Пароль</label>
            <input type="text" name="password" value="{{ $password }}" required>
          </fieldset>
          <p class="notice mb-1 full">
            Увага, якщо ви плануєте використовувати згенерований
            пароль то збережіть його перед відправкою так як пароль буде зашифровано.
          </p>
          <fieldset>
            <label class="label">Роль</label>
            <select name="role">
              <option value="null" selected disabled>Обрати роль</option>
                @if(!empty($roles))
                    @foreach($roles as $role => $value)
                        <option value="{{ $role }}">{{ $value }}</option>
                    @endforeach
                @endif
            </select>
          </fieldset>

        </div>
      </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ dump($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </form>
  </div>
</div>
@endsection
