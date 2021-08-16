@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<input type="file" name="image" id="image"><br/>
<input type="text" name="title" id="title" value="{{ $post->title ??  old('title')}}" placeholder="Título"><br/>
<textarea name="content" id="content" cols="30" rows="4" placeholder="Conteúdo">{{ $post->content ?? old('content') }}</textarea><br/>
<button type="submit">Enviar</button>
