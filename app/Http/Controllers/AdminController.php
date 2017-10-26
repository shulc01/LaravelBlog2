<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Art_Tag;
use App\Models\Image;
use App\Models\Article_Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{   

    public $optionCategories;

    public function showAdmin() 
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

        $tagsEditArticle = $editArticle->tags;

        $imagesEditArticle = $editArticle->images;

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listcategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }
        
        $this->outTree($listcategories, 0, 0, $editArticle->category_id);

        $tags = Tag::all();

        if (collect($tagsEditArticle)->isNotEmpty()) {

            $tagsArticle = '';

            foreach ($tagsEditArticle as $tagEditArticle) {

                $tagsArticle .= $tagEditArticle->name . '; ';

                $tagsIdArticle[] = $tagEditArticle->id;
            }

            $data = [                   
                    'editArticle' => $editArticle,
                    'categories' => $categories,
                    'tags' => $tags,
                    'tagsArticle' => $tagsArticle,
                    'tagsIdArticle' => $tagsIdArticle,
                    'imagesEditArticle' => $imagesEditArticle,
                    'optionCategories' => $this->optionCategories
                    ];

            return view('editArticle')->with($data);

        }

        $data = [
                'editArticle' => $editArticle,
                'categories' => $categories,
                'tags' => $tags,
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

        if (!empty($data['custom_tags'])) $customTags = $data['custom_tags'];
        if (!empty($data['tags_id'])) $tagsFromDB = $data['tags_id'];

        if (empty($customTags) && ((empty($tagsFromDB)) || $tagsFromDB[0] == 0)) { //no tags or selected 'no tags'

            $article = Article::create($data);

            if (!empty($filesNames)) {

                foreach ($filesNames as $fileName) {

                    $idImage[] = Image::insertGetId($fileName);
                }

                $article->images()->attach($idImage);
            } 

            return redirect('/admin');
        }

        if (!empty($customTags)) {

            $customTags = explode(';', mb_strtolower($customTags));

            $customTags = array_unique(array_diff(array_map('trim', $customTags), ['', 0, null]));

            $tagsIs = Tag::where(function ($query) use ($customTags) {

                foreach($customTags as $customTag){

                    $query->orWhere('name', $customTag);

                }
            })->get();

            if (collect($tagsIs)->count() > 0) {   //isset tag in DB

                 foreach ($tagsIs as $tagIs) {

                    foreach ($customTags as $key => $customTag) {

                        if ($tagIs->name == $customTag) { 

                            unset($customTags[$key]);

                            $idsTags[] = $tagIs->id;
                        }      
                    }
                } 
            }

            if (!empty($tagsFromDB)) { 

                foreach ($tagsFromDB as $tagsId) {

                    if ($tagsId == 0) break;

                    $idsTags[] = $tagsId;
                }
            }

            if (!empty($customTags)) {   //if really new tags

                foreach ($customTags as $customTag) {

                    $tags = ['name' => $customTag];

                    $idsTags[] = Tag::insertGetId($tags);
                }
            }

            $idsTags = array_unique($idsTags);

            foreach ($idsTags as $idTag) {

                $articleTag[] = $idTag;
            }

            $article = Article::create($data);

            $article->tags()->attach($articleTag);

            if (!empty($filesNames)) {

                foreach ($filesNames as $fileName) {

                    $idImage[] = Image::insertGetId($fileName);
                }

                $article->images()->attach($idImage);
            } 

            return redirect('/admin');
        }

        if ($tagsFromDB) {

            $article = Article::create($data);

            $article->tags()->attach($tagsFromDB);

            if (!empty($filesNames)) {

                foreach ($filesNames as $fileName) {

                    $idImage[] = Image::insertGetId($fileName);
                }

                $article->images()->attach($idImage);
            } 

            return redirect('/admin');
        }

    } // end storeArticle

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

        if (!empty($data['custom_tags'])) {
            
            $customTags = $data['custom_tags'];
            
        }   

        unset($data['custom_tags']);

        if ( (!empty($data['tags_id']) && $data['tags_id'][0] == 0) || !empty($data['tags_id']) ) {

            $tagsFromDB = $data['tags_id'];
            unset($data['tags_id']);
        }

        $idEditArticle = $data['id'];

        if (empty($customTags) && ( (empty($tagsFromDB)) || $tagsFromDB[0] == 0) ) { //no tags or selected 'no tags'

            $deleteArticleTags = Art_Tag::where('article_id', $idEditArticle)->delete();

            Article::where('id', $idEditArticle)->update($data);

                if (!empty($filesNames)) {

                    foreach ($filesNames as $fileName) {

                        $idImage[] = Image::insertGetId($fileName);

                    }

                    $article = Article::find($idEditArticle)->images()->attach($idImage);
                } 

            return redirect('/admin');
        }

        if (!empty($customTags)) {

            $customTags = explode(';', mb_strtolower($customTags));

            $customTags = array_unique(array_diff(array_map('trim', $customTags), ['', 0, null]));

            Article::where('id', $idEditArticle)->update($data);

            $tagsIs = Tag::where(function ($query) use ($customTags) {

                foreach($customTags as $customTag){

                    $query->orWhere('name', $customTag);

                }

            })->get();

            if (collect($tagsIs)->count() > 0) {  //isset tag in DB

                 foreach($tagsIs as $value) {

                    foreach ($customTags as $key => $customTag) {

                        if ($value->name == $customTag) { 

                            unset($customTags[$key]);

                            $idsTags[] = $value->id;
                        }      
                    }
                } 
            }

            if (!empty($tagsFromDB)) {

                foreach ($tagsFromDB as $tagsId) {

                    if ($tagsId == 0) break;

                    $idsTags[] = $tagsId;

                }
            }

            if (!empty($customTags)) {

                foreach ($customTags as $customTag) {

                    $tags = ['name' => $customTag];

                    $idsTags[] = Tag::insertGetId($tags);

                }
            }

            $idsTags = array_unique($idsTags);

            $deleteArticleTags = Art_Tag::where('article_id', $idEditArticle)->delete();

            foreach ($idsTags as $idTag) {

                 $articleTag[] = ['article_id' => $idEditArticle, 'tag_id' => $idTag];

            }

            $saveArticleTags = Art_Tag::insert($articleTag);

            if (!empty($filesNames)) {

                foreach ($filesNames as $fileName) {

                    $idImage[] = Image::insertGetId($fileName);

                }

                $article = Article::find($idEditArticle)->images()->attach($idImage);
            } 

            return redirect('/admin');
        }

        if ($tagsFromDB) {

            $deleteArticleTags = Art_Tag::where('article_id', $idEditArticle)->delete(); 

            $article = Article::find($idEditArticle);
            $article->fill($data);
            $article->tags()->attach($tagsFromDB);
            $article->save();

            if (!empty($filesNames)) {

                foreach ($filesNames as $fileName) {

                    $idImage[] = Image::insertGetId($fileName);

                }

                $article->images()->attach($idImage);
            } 

            return redirect('/admin');

        }

    } //end function saveArticle

    public function createArticle()
    {

        $categories = Category::all()->toArray();

        foreach ($categories as $category) {

            $listcategories[$category['parent_id']][] = [$category['id'], $category['name']];

        }
        
        $this->outTree($listcategories, 0, 0);

        $tags = Tag::all();

        $data = [
                'tags' => $tags,
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

} //end class AdmiController