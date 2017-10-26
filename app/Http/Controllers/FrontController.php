<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\View;

class FrontController extends Controller
{

    public $optionCategories;

    public function __construct()
    {

        $lastArticles = Article::limit(5)->orderBy('updated_at', 'desc')->get();

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

    public function showAllArticles()
    {

        $articles = Article::all()->sortByDesc('updated_at');

        return view('page')->with('articles', $articles);

    }

    public function showArticle($id)
    {

        $article = Article::find($id);


        $category = $article->category;

        $articleTags = $article->tags;

        $articleImages = $article->images;
        
            $data = [
                    'article' => $article,
                    'category' => $category,
                    'articleTags' => $articleTags,
                    'articleImages' => $articleImages
                    ];

        return view('single-article')->with($data);

    }

    public function showAllCategories()
    {

        return view('show-cat');

    }

    public function showArticlesFromCategory($id)
    {

        $category = Category::find($id);

        $categoryName = $category->name;

        $articles = $category->articles()
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
                'categoryName' => $category->name,
                'articles' => $articles
                ];

            return view('page')->with($data);

    }

    public function deleteCategory($id)
    {

        Category::find($id)->delete();

        return redirect('/categories');

    }

    public function showArticleWithTags($id)
    {

        $tag = Tag::find($id);

        $tagName = $tag->name;

        $articlesWithTags = $tag->articles()->orderBy('updated_at', 'desc')->get();

        $data = [
                'articles' => $articlesWithTags,
                'tagName' => $tagName
                ];

        return view('page')->with($data);

    }

}