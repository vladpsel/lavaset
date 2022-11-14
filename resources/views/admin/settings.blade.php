@extends('admin.layout')

@section('title', 'Налаштування')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
  </aside>
  <div class="dashboard-panel">
      <div class="full mb-1">
          <h1 class="title-main">Налаштування сайту</h1>
      </div>
      <div class="one-of-three mx-w">
          <form action="#" method="post" class="form-main" enctype="multipart/form-data">
              @csrf
              <fieldset>
                  <label class="label">Назва сайту</label>
                  <input type="text" name="sitename" value="{{ $config['sitename'] }}">
              </fieldset>
              @if(!empty($config['favicon']))
                  <div class="img-wrp mb-1">
                      <img src="/upload/{{ $config['favicon'] }}" alt="">
                  </div>
                  <div class="mb-1">
                      <button type="submit" name="remove-icon" class="error">Очистити</button>
                  </div>
              @endif
              <fieldset>
                  <label class="label">Іконка сайту</label>
                  <input type="file" name="favicon">
              </fieldset>

              @if(!empty($config['logo']))
                  <div class="img-wrp mb-1">
                      <img src="/upload/{{ $config['logo'] }}" alt="">
                  </div>
                  <div class="mb-1">
                      <button type="submit" name="remove-logo" class="error">Очистити</button>
                  </div>
              @endif
              <fieldset>
                  <label class="label">Лого</label>
                  <input type="file" name="logo">
              </fieldset>

              <fieldset>
                  <button type="submit" name="submit" class="btn btn-main primary">Зберегти</button>
              </fieldset>

          </form>
      </div>
  </div>
</div>
@endsection
