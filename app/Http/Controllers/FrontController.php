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

        $listCategories = $this->buildTree();

        $data = [
            'lastArticles' => $lastArticles,
            'listCategories' => $listCategories,
        ];

        View::share($data);

    }

    public function showArticles()
    {

        $articles = Article::all()->sortByDesc('updated_at');

        return view('front.allArticles')->with('articles', $articles);

    }

    public function showArticle($id)
    {

        $article = Article::find($id);
        $article->category;
        $article->images;

        return view('front.showArticle')->with('article', $article);

    }

    public function showCategories()
    {

        $listCategories = $this->buildTree();

        return view('front.showCategories')->with('listCategories', $listCategories);

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

        return view('front.allArticles')->with($data);

    }

    public function deleteCategory($id)
    {

        Category::find($id)->delete();

        return redirect('/categories');

    }

    protected function buildTree()
    {

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }

        return $listCategories;
    }
}