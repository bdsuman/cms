<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function CategoryPage(){
        return view('pages.dashboard.category-page');
    }

    function CategoryList(Request $request){
        $user_id=$request->header('id');
        return Category::where('user_id',$user_id)->get();
    }

    function CategoryCreate(Request $request){
        $user_id=$request->header('id');
        return Category::create([
            'name'=>$request->input('name'),
            'user_id'=>$user_id
        ]);
    }

    function CategoryDelete(Request $request){
        $category_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->delete();
    }


    function CategoryByID(Request $request){
        $category_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->first();
    }



    function CategoryUpdate(Request $request){
        $category_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->update([
            'name'=>$request->input('name'),
        ]);
    }

    public function ArticleCategoryList(Request $request){
        $id = $request->input('id');
        $article = Article::find($id);
        $categories =  $article->categories()->pluck('id')->toArray();
        // $all_category = Category::where('user_id',$user_id);

        // $new_collection = collect($all_category)->map(function ($arr) use ($role_permit) {
        //     $arr['name'] = Str::headline($arr->name);
        //     if(in_array($arr->id,$role_permit)){
        //         $arr['checked'] = 'checked';
        //     }else{
        //         $arr['checked'] = '';
        //     }
        //     return $arr;
        // });

        return  $categories;

    }
}
