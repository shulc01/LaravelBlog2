<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use App\Models\Article_Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{   

    public $optionCategories;

    public function index()
    {

        $articles = Article::with('category')->orderBy('created_at', 'desc')->get();

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

        $editArticle = Article::find($id);

        $imagesEditArticle = $editArticle->images;

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listcategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }
        
        $this->outTree($listcategories, 0, 0, $editArticle->category_id);

        $data = [
            'editArticle' => $editArticle,
            'categories' => $categories,
            'imagesEditArticle' => $imagesEditArticle,
            'optionCategories' => $this->optionCategories
        ];

        return view('editArticle')->with($data);
    }

    public function storeArticle(Request $request) 
    {

        $this->validate($request,
             [ 'title' => 'required|min:3',
                'description' => 'required|min:3',
                'image' => 'required|',
                'text' => 'required|min:3'
             ]);

        $data = $request->all();
        $fileName = Image::store($file);
        $mainFoto = 'm_' . rand(1, 999999) . time() . '.' . $data['image']->getClientOriginalExtension();
        $data['image']->move(public_path('/storage/images/'), $mainFoto);
        $data['image'] = $mainFoto;

        if (!empty($data['images'])) {

            $files = $data['images'];

            foreach ($files as $file) {

                $fileName = rand(1, 999999) . time() . '.' . $file->getClientOriginalExtension();
                $filesNames[] = ['name' => $fileName];
                $file->move(public_path('/storage/images/'), $fileName);
            }
        } 
        unset($data['images']);

            $article = Article::create($data);

            if (!empty($filesNames)) {

                foreach ($filesNames as $fileName) {

                    $idImage[] = Image::insertGetId($fileName);
                }

                $article->images()->attach($idImage);
            } 

            return redirect('/admin');

    }

    public function updateArticle(Request $request)
    {

        $this->validate($request,
             [ 'title' => 'required|min:3',
                'description' => 'required|min:3',
                'text' => 'required|min:3',
             ]);

        $data = $request->except('_token');

        if (empty($data['image'])) {

            $data['image'] = $data['mainImage'];

        } else {

            $mainFoto = 'm_' . rand(1, 999999) . time() . '.' . $data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('/storage/images/'), $mainFoto);
            $data['image'] = $mainFoto;
        } 

        unset ($data['mainImage']);

        if (!empty($data['images'])) {

            $files = $data['images'];

            foreach ($files as $file) {

                $fileName = rand(1, 999999) . time() . '.' . $file->getClientOriginalExtension();
                $filesNames[] = ['name' => $fileName];
                $file->move(public_path('/storage/images/'), $fileName);
            }
        } 
        unset($data['images']);

        $idEditArticle = $data['id'];

            Article::where('id', $idEditArticle)->update($data);

                if (!empty($filesNames)) {

                    foreach ($filesNames as $fileName) {

                        $idImage[] = Image::insertGetId($fileName);

                    }

                    $article = Article::find($idEditArticle)->images()->attach($idImage);
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
                'optionCategories' => trim($this->optionCategories)
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

        Image::find($imId)->delete();

        return $this->editArticle($articleId);
  
    }

    public function deleteMainFotoArticle($image, $articleId) 
    {

        unlink("storage/images/" . $image);

        Article::where('id', $articleId)->update(['image' => null]);

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

        $this->validate($request,
                        ['name' => 'required|min:3',
                         'description' => 'required|min:3',
                         'parent_id' => 'required'
                        ]);

        $data = $request->all(); 

        $category = new Category; 
        $category->fill($data);
        $category->save();

        return redirect('/admin');
    }

}