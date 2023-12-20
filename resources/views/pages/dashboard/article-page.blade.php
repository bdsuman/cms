@extends('layout.sidenav-layout')
@section('content')
    @include('components.article.list')
    @include('components.article.delete')
    @include('components.article.create')
    @include('components.article.update')
@endsection
