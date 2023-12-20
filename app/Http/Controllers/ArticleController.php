<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{

    function ArticlePage():View{
        return view('pages.dashboard.article-page');
    }


    function CreateArticle(Request $request)
    {
        $user_id=$request->header('id');

        // Prepare File Name & Path
        $img=$request->file('img');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";


        // Upload File
        $img->move(public_path('uploads'),$img_name);

        $slug = Str::slug($request->input('title'));
        $same_slug_count = Article::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;
       
       $article = Article::create([
                'content'=>$request->input('content'),
                'title'=>$request->input('title'),
                'img_url'=>$img_url,
                'slug'=>$slug,
                'user_id'=>$user_id
            ]);

        $article->categories()->attach(explode(',',$request->input('category_id')));

        return $article;
    }


    function DeleteArticle(Request $request)
    {
        $user_id=$request->header('id');
        $id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Article::where('id',$id)->where('user_id',$user_id)->delete();
    }


    function ArticleByID(Request $request)
    {
        $user_id=$request->header('id');
        $article_id=$request->input('id');
        return Article::where('id',$article_id)->where('user_id',$user_id)->first();
    }


    function ArticleList(Request $request)
    {
        $user_id=$request->header('id');
        return Article::where('user_id',$user_id)->get();
    }
    function ArticleByCategoryID($id)
    {
        
        $category = Category::find($id);
        dd($category->article()->get()->toArray());
        // return 
        // return Article::where('user_id',$user_id)->get();
    }




    function UpdateArticle(Request $request)
    {
        $user_id=$request->header('id');
        $id=$request->input('id');
       
        if ($request->hasFile('img')) {

            // Upload New File
            $img=$request->file('img');
            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            // Delete Old File
            $filePath=$request->input('file_path');
            File::delete($filePath);

            // Update Product

            $article=Article::where('id',$id)->where('user_id',$user_id)->update([
                'content'=>$request->input('content'),
                'title'=>$request->input('title'),
                'img_url'=>$img_url,
            ]);

        }

        else {
            $article= Article::where('id',$id)->where('user_id',$user_id)->update([
                'content'=>$request->input('content'),
                'title'=>$request->input('title'),
            ]);
        }
        
        $newObj = Article::where('id',$id)->where('user_id',$user_id)->first();
        $newObj->categories()->detach();
        $newObj->categories()->attach(explode(',',$request->input('category_id')));

        return $article;
    }
}
