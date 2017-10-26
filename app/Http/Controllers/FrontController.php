<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\View;

class FrontController extends Controller
{

    public $optionCategories;

    public function __construct()
    {

        $lastArticles = Article::limit(5)
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }

        $this->outTree($listCategories, 0, 0);

        $data = [
            'lastArticles' => $lastArticles,
            'allCategories' => $this->optionCategories,
        ];

        View::share($data);

    }

    public function outTree($listCategories, $parent_id, $level) 
    {

        if (isset($listCategories[$parent_id])) { 

            foreach ($listCategories[$parent_id] as $value) { 

               $this->optionCategories .=  '<li><a href = /category/' . $value[0] . ' ><h' . ($level + 2) .'>';

               for ($i = 0; $i <= $level; $i++) {

                    $this->optionCategories .= '- ';

                }

                $this->optionCategories .= $value[1] . '</h' . ($level + 2) .'></a></li>';

                $level++;
                    
                $this->outTree($listCategories, $value[0], $level);

                $level--; 

            }
        }
    }

    public function showArticles()
    {

        $articles = Article::all()->sortByDesc('updated_at');

        return view('allArticles')->with('articles', $articles);

    }

    public function showArticle($id)
    {

        $article = Article::find($id);
        $article->category;
        $article->images;

        return view('showArticle')->with('article', $article);

    }

    public function showCategories()
    {

        return view('showCategories');

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

        return view('allArticles')->with($data);

    }

    public function deleteCategory($id)
    {

        Category::find($id)->delete();

        return redirect('/categories');

    }

}