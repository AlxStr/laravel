@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs mb-3">
        <li class="li nav-item"><a href=" {{ route('admin.home') }} " class="nav-link active">Dashboard</a></li>
        <li class="li nav-item"><a href=" {{ route('admin.users.index') }} " class="nav-link active">Users</a></li>
    </ul>
@endsection
