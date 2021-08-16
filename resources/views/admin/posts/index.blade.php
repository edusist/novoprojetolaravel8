@extends('admin.layouts.app')


@section('title', 'Listagem dos Posts')

@section('content')
    <hr>
    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('posts.search') }}" method="post">

        @csrf
        <input type="search" name="filtrar" id="filtrar" placeholder="Pesquisar...">
        <button type="submit">Buscar</button>
    </form>

    <h1>Novos posts</h1>
    <a href="{{ route('posts.create') }}">
        <h3>Cadastrar post</h3>
    </a>

    @foreach ($posts as $post)
        <p>{{ $post->id }}</p>
        <p>{{ $post->title }}</p>
        {{$post->image  }}
        <p><img src="{{ url("storage/{$post->image}") }}" alt="{{ $post->title }}" style="max-width:200px;"></p>
        <p>

            [ <a href="{{ route('posts.show', $post->id) }}">Detalhes</a>
            | <a href="{{ route('posts.edit', $post->id) }}">Alterar</a>
            ]
        </p>

    @endforeach
    <hr>
    @if (isset($filtros))
        {{ $posts->appends($filtros)->links() }}

    @else
        {{ $posts->links() }}
    @endif

@endsection
