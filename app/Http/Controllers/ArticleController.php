<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

        // Save To Database
        return Article::create([
            'content'=>$request->input('content'),
            'title'=>$request->input('title'),
            'img_url'=>$img_url,
            'slug'=>$slug,
            'user_id'=>$user_id
        ]);
    }


    function DeleteArticle(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }


    function ArticleByID(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->where('user_id',$user_id)->first();
    }


    function ArticleList(Request $request)
    {
        $user_id=$request->header('id');
        return Article::where('user_id',$user_id)->get();
    }




    function UpdateArticle(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');

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

            return Article::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);

        }

        else {
            return Article::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id'),
            ]);
        }
    }
}
