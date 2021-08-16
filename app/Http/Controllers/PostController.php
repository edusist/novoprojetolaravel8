<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacaoFormulario;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::oldest()->paginate(3); //Post::orderBy('id', 'ASC')->paginate(3);
        //dd($posts);
        return view("admin.posts.index", compact('posts'));
    }
    public function create()
    {

        return view("admin.posts.create");
    }

    public function store(ValidacaoFormulario $requisicao)
    {
        $dados = $requisicao->all();

        $imagem = $requisicao->image;

        if ($imagem->isValid()) :

            $nome_arquivo = Str::of($requisicao->title)->slug('-') . '.' . $requisicao->image->getClientOriginalExtension();
            //dd($nome_arquivo);
            $arquivo_imagem = $imagem->storeAs('posts', $nome_arquivo);


            $dados['image'] = $arquivo_imagem;
            // dd($dados['image']);
        endif;
        Post::create($dados);
        return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
    }

    public function show($id)
    {

        $post =  Post::where('id', $id)->first();

        if (!$post) :

            return redirect()->route('posts.index');
        endif;

        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {

        $post =  Post::find($id);

        if (!$post) :

            return redirect()->route('posts.index');
        endif;

        //Saber se tem o arquivo da imagem para poder deletar e adicionar um novo
        if (Storage::exists($post->image)) {
            Storage::delete($post->image);
        }


        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post excluído com sucesso!');
    }

    public function edit($id)
    {

        $post =  Post::where('id', $id)->first();

        if (!$post) :

            return redirect()->back();
        endif;

        return view('admin.posts.edit', compact('post'));
    }

    public function update(ValidacaoFormulario $requisicao, $id)
    {
        if (!$post = Post::find($id)) {
            return redirect()->back();
        }

        $data = $requisicao->all();

        if ($requisicao->image && $requisicao->image->isValid()) {


            if (Storage::disk('public')->exists($post->image))
                Storage::disk('public')->delete($post->image);


            $nameFile = Str::of($requisicao->title)->slug('-') . '.' .$requisicao->image->getClientOriginalExtension();

            $image = $requisicao->image->storeAs('posts', $nameFile);
            //dd($image);

            $data['image'] = $image;

        }

        $post->update($data);
        //dd($retorno);

        return redirect()->route('posts.index')->with('success', 'Post alterado com sucesso!');
    }

    public function search(Request $request)
    {
        $filtros = $request->except('_token');
        $posts = Post::where('title', 'LIKE', "%{$request->filtrar}%")->orWhere('content', 'LIKE', "%{$request->filtrar}%")->paginate(2);
        return view('admin.posts.index', compact('posts', 'filtros'));
        //->toSql() -retorna o formato sql do BD
    }
}
  /*   'title'   => $requisicao->title,
        'content' => $requisicao->title
        dd($requisicao->all());//$requisicao->title,$requisicao->title */
