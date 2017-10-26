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
        //dump($categories);
        //$categories->mapWithKeys (function ($item, $key) {

//dump($item->parent_id);
            //dump($key);
            //if ($item->parent_id == $item->id) {

            //return   [$item[$item->parent_id] => [$item->id]];

            //}

           // return $list;
//dump($list);

//dump($categories);
            /*foreach($categories as $category) {
dump($category);
                $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];

            }*/

            //return $listCategories;

        //});

        //$t->all();
        dump($listCategories);
        //dump($categories->all());
        //dump($t);
//dd(2);

        //dd($r->all());

//        foreach ($categories as $category) {
//
//            $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];
//
//        }

        //$this->outTree($listCategories, 0, 0);

        $data = [
            'lastArticles' => $lastArticles,
            'listCategories' => $listCategories,
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
                    
                //$this->outTree($listCategories, $value[0], $level);

                $level--; 

            }
        }
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