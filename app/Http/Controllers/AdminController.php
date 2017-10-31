<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $articles = Article::with('category')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.adminShow')->with('allArticles', $articles);
    }

    public function editArticle($id) 
    {
        $article = Article::with('Category', 'Images')
            ->find($id);

        $listCategories = $this->buildTree();

        $data = [
            'article' => $article,
            'listCategories'=> $listCategories
        ];

        return view('admin.editArticle')->with($data);
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

        $data['content'] = [
            "description" => $data['description'],
            "body" => $data['text']
        ];

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

        $data['content'] = [
            "description" => $data['description'],
            "body" => $data['text']
        ];

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
        $listCategories = $this->buildTree();

        return view('admin.createArticle')->with('listCategories', $listCategories);
    }

    public function deleteArticle($id)
    {
        Article::find($id)->delete();

        return redirect('/admin');
    }

    public function deleteImagesArticle($imId, $articleId) 
    {

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
        $listCategories = $this->buildTree();

        return view('admin.createCategory')->with('listCategories', $listCategories);

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

    protected function buildTree()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            $listCategories[$category['parent_id']][] = [$category['id'], $category['name']];
        }

        return $listCategories;
    }

}