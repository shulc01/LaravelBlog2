<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\View;

class FrontController extends Controller
{

    public function __construct()
    {

        $lastArticles = Article::limit(5)
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }

        $data = [
            'lastArticles' => $lastArticles,
            'listCategories' => $listCategories,
        ];

        View::share($data);

    }

    public function showArticles()
    {

        $articles = Article::all()->sortByDesc('updated_at');

        return view('layouts.front.allArticles')->with('articles', $articles);

    }

    public function showArticle($id)
    {

        $article = Article::find($id);
        $article->category;
        $article->images;

        return view('layouts.front.showArticle')->with('article', $article);

    }

    public function showCategories()
    {

        return view('layouts.front.showCategories');

    }

    public function showArticlesFromCategory($id)
    {

        $category = Category::find($id);

        $articles = $category
            ->articles()
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            'category' => $category->name,
            'articles' => $articles
        ];

        return view('layouts.front.allArticles')->with($data);

    }

    public function deleteCategory($id)
    {

        Category::find($id)->delete();

        return redirect('/categories');

    }
}