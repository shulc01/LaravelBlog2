<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_Image;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class AdminController extends Controller
{   

    public $optionCategories;

    public function index()
    {

        $articles = Article::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('adminShow')->with('allArticles', $articles);
    }

    public function outTree($listCategories, $parent_id, $level, $categoryIdArticle = false)
    {

        if (isset($listCategories[$parent_id])) {
 
            foreach ($listCategories[$parent_id] as $value) {

               $this->optionCategories .=  '<option value = ' . $value[0];

               if ($value[0] == $categoryIdArticle) {

                    $this->optionCategories .=  ' selected ';

                }

                $this->optionCategories .= '>';

                for ($i = 0; $i <= $level; $i++) {  //?????

                    $this->optionCategories .= ' - ';

                }

                $this->optionCategories .= $value[1]. '</option>';

                $level++;
                    
                $this->outTree($listCategories, $value[0], $level, $categoryIdArticle);

                $level--; 

            }
        }
    }

    public function editArticle($id) 
    {

        $article = Article::find($id);

        $article->images;

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listcategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }
        
        $this->outTree($listcategories, 0, 0, $article->category_id);

        $data = [
            'article' => $article,
            'categories' => $categories,
            'optionCategories' => $this->optionCategories
        ];

        return view('editArticle')->with($data);
    }

    public function storeArticle(Request $request) 
    {

        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'image' => 'required|',
            'text' => 'required|min:3'
        ]);

        $data = $request->except('_token');

        $data['image'] = Image::store($data['image']);

        $article = Article::create($data);

        if (!empty($data['images'])) {

            foreach ($data['images'] as $image) {

                $fileName = ['name' => Image::store($image)];

                $idImage[] = Image::insertGetId($fileName);

            }

            $article->images()->attach($idImage);
        }


        return redirect('/admin');

    }

    public function updateArticle(Request $request)
    {

        $dataValidate = $request->validate ([
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'text' => 'required|min:3'
        ]);

        $data = $request->except('_token', 'title', 'description', 'text');
        $data = array_merge($dataValidate, $data);

        empty($data['image']) ? $data['image'] = $data['mainImage'] : $data['image'] = Image::store($data['image']);

        $articleId = $data['id'];

        Article::find($articleId)->update($data);

        if (!empty($data['images'])) {

            foreach ($data['images'] as $image) {

                $fileName = ['name' => Image::store($image)];

                $idImage[] = Image::insertGetId($fileName);

            }

            Article::find($articleId)->images()->attach($idImage);
        }

        return redirect('/admin');

    }

    public function createArticle()
    {

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listcategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }
        
        $this->outTree($listcategories, 0, 0);

        $data = [
                'optionCategories' => $this->optionCategories
                ];

        return view('createArticle')->with($data);
    }

    public function deleteArticle($id)
    {

        Article::find($id)->delete();

        return redirect('/admin');

    }

    public function deleteImagesArticle($imId, $articleId) 
    {

        Article_Image::where('image_id', $imId)->delete();

        $deleteImages = Image::find($imId);

        unlink("storage/images/" . $deleteImages->name);

        $deleteImages->delete();

        return $this->editArticle($articleId);
  
    }

    public function deleteMainFotoArticle($image, $articleId) 
    {

        unlink("storage/images/" . $image);

        Article::find($articleId)->update(['image' => null]);

        return $this->editArticle($articleId);
  
    }

    public function createCategory()
    {

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }
        
        $this->outTree($listCategories, 0, 0);

        $data = ['allCategories' => $this->optionCategories];

        return view('add-cat')->with($data);

    }

    public function saveCategory(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'parent_id' => 'required'
        ]);

        $data = $request->all(); 

        $category = new Category; 
        $category->fill($data)->save();

        return redirect('/admin');
    }

}