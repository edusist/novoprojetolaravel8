@extends('admin.layouts.app')

@section('title', 'Detalhes dos posts')
@section('content')
<h1>Detalhes dos posts {{ $post->title}}</h1>

<ul>
    <li><strong>Título: </strong>{{ $post->title}}</li>
    <li><strong>Descrição: </strong>{{ $post->content}}</li>
</ul>

<form action="{{ route('posts.destroy', $post->id) }}" method="post">
    @csrf

    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">Excluir | {{ $post->title}}</button>
</form>
@endsection
