@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div id="admin">

    <admin-app
        :pages={{$pages}}
    >
        <template v-slot:aside>
            @include('admin.partials._admin-aside')
        </template>
    </admin-app>

</div>
@endsection
