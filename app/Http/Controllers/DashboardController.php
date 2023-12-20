<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }

    function Summary(Request $request):array{

        $user_id=$request->header('id');

        $article= Article::where('user_id',$user_id)->count();
        $Category= Category::where('user_id',$user_id)->count();
       
        return[
            'product'=> $article,
            'category'=> $Category
        ];


    }
}
