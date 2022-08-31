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
        $articles = Article::all();

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
        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'number' => 'required|unique:articles',
            'title' => 'required|min:1|unique:articles,title,NULL,id,deleted_at,NULL',
            'pub_year' => 'required',
            'file' => 'required',
            'cover' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        if ($request->hasFile('file')) {
            $this->file_path = $request->file('file')->storeAs(
                config('app.name') . '/MAKALA/',
                $request->title . '.' . $request->file('file')->getClientOriginalExtension(),
                'public'
            );
        } else return response()->json(['error' => 'Add a article file'], 404);

        if ($request->hasFile('cover')) {
            $this->cover_path = $request->file('cover')->storeAs(
                config('app.name') . '/ARTICLE-COVERS/',
                $request->title . '.' . $request->file('cover')->getClientOriginalExtension(),
                'public'
        );
        } else return response()->json([
            'error' => 'Add an article cover'
        ], 404);

        $article = new Article();
        $article->number = $request->input('number');
        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->pub_year = $request->input('pub_year');
        $article->file = $this->file_path;
        $article->cover = $this->cover_path;

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
        $article = Article::find($articleId);

        if (!$article) {
            return response()->json(['error' => "Article not found"], 404);
        }
        $articleFileToDelete = $article->file;
        $articleCoverToDelete = $article->cover;
        if ($request->hasFile('file')) {
            $new_file_path = $request->file('file')->storeAs(
                config('app.name') . '/MAKALA/',
                $request->title . '.' . $request->file('file')->getClientOriginalExtension(),
                'public'
            );
        } else
            $new_file_path = config('app.name') . '/MAKALA/' . $request->title;
        Storage::disk('public')->move($article->file, $new_file_path);

        if ($request->hasFile('cover')) {
            $new_cover_path = $request->file('cover')->storeAs(
                config('app.name') . '/ARTICLE-COVERS/',
                $request->title . '.' . $request->file('cover')->getClientOriginalExtension(),
                'public'
            );
        } else
            $new_cover_path = config('app.name') . '/ARTICLE-COVERS/' . $request->title;
        Storage::disk('public')->move($article->cover, $new_cover_path);

        $article->update([
            'number' => $request->input('number'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'pub_year' => $request->input('pub_year'),
            'file' => $new_file_path,
            'cover' => $new_cover_path

        ]);
        $article->save();
        Storage::disk('public')->delete($articleFileToDelete);
        Storage::disk('public')->delete($articleCoverToDelete);

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
        Storage::disk('public')->delete($article->cover);

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

    public function viewArticleCover($articleId)
    {
        $article = Article::find($articleId);
        if (!$article) {
            return response()->json([
                'error' => 'Article not found'
            ], 404);
        }

        $pathToFile = storage_path('/app/public/' . $article->cover);
        return response()->download($pathToFile);
    }
}
