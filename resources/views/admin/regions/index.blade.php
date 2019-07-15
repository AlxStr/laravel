@extends('layouts.app')

@section('content')
    @include('admin.regions._nav')

    <p><a href="{{ route('admin.regions.create') }}" class="btn btn-success text-light">Add Region</a></p>

    @include('admin.regions._list', $regions)
@endsection
