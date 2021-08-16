@extends('admin.layouts.app')
@section('title', 'Alterar Posts')

@section('content')
<h1>.::Alterar posts => {{ $post->title }}::.</h1>

<form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
    {{-- Tipo de método tem ser PUT e não UPDATE --}}
    @csrf
    @method('put')
    @include('admin.posts._partials.form')

</form>
@endsection
