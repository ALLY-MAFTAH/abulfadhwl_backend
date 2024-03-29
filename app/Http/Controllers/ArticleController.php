<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // Get all articles
    public function getAllArticles()
    {
        $articles = Article::orderBy('number','ASC')->get();

        if (REQ::is('api/*'))
            return response()->json([
                'articles' => $articles
            ], 200);
        return view('turaath/documents/all_articles')->with('articles', $articles);
    }

    // Get a single article
    public function getSingleArticle($articleId)
    {
        $article = Article::find($articleId);
        if (!$article) {
            return response()->json([
                'error' => "Article not found"
            ], 404);
        }
        if (REQ::is('api/*'))
            return response()->json([
                'article' => $article
            ], 200);
        return view('turaath/documents/article')->with('article', $article);
    }

    // Post article
    public function postArticle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|min:1|unique:articles,number,NULL,id',
            'title' => 'required|min:1',
            'pub_year' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors(),]);
        }

        if ($request->hasFile('file')) {
            $this->file_path = $request->file('file')->storeAs(
                config('app.name') . '/MAKALA/',
                $request->title . '.' . $request->file('file')->getClientOriginalExtension(),
                'public'
            );
        } else return back()->with(['error' => 'Add a article file']);

        $article = new Article();
        $article->number = $request->input('number');
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->pub_year = $request->input('pub_year');
        $article->file = $this->file_path;

        $article->save();

        if (REQ::is('api/*'))
            return response()->json([
                'article' => $article
            ], 201);
        return back()->with('success', 'Article added successfully');
    }

    // Edit article
    public function putArticle(Request $request, $articleId)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|unique:articles,number,' . $articleId . ',id',
            'title' => 'required',
            'pub_year' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()]);
        }

        $article = Article::find($articleId);
        if (!$article) {
            return response()->json(['error' => "Article not found"], 404);
        }
        if ($request->hasFile('file')) {
            $new_file_path = $request->file('file')->storeAs(
                config('app.name') . '/MAKALA/',
                $request->title . '.' . $request->file('file')->getClientOriginalExtension(),
                'public'
            );

        } else {

            $new_file_path = config('app.name') . '/MAKALA/' . $request->title . '.pdf';
        }
        Storage::disk('public')->move($article->file, $new_file_path);

        $article->update([
            'number' => $request->input('number'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'pub_year' => $request->input('pub_year'),
            'file' => $new_file_path,

        ]);
        $article->save();

        if (REQ::is('api/*'))
            return response()->json([
                'article' => $article
            ], 201);
        return back()->with('success', 'Article edited successfully');
    }

    // Delete article
    public function deleteArticle($articleId)
    {
        $article = Article::find($articleId);
        if (!$article) {
            return response()->json([
                'error' => 'Article does not exist'
            ], 204);
        }
        Storage::disk('public')->delete($article->file);

        $article->delete();
        if (REQ::is('api/*'))

            return response()->json([
                'article' => 'Article deleted successfully'
            ], 200);
        return back()->with('success', 'Article deleted successfully');
    }

    public function viewArticleFile($articleId)
    {
        $article = Article::find($articleId);
        if (!$article) {
            return response()->json([
                'error' => 'Article not exists'
            ], 404);
        }
        $pathToFile = storage_path('/app/public/' . $article->file);
        return response()->download($pathToFile);
    }
}
