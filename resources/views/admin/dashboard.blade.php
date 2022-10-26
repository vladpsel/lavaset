@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div id="admin">
  <aside class="admin-aside">
    @include('admin.partials._admin-aside')
  </aside>
  <div class="dashboard-panel">

  </div>
</div>
@endsection
