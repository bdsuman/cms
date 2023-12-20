<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomePage(){
        $articles = Article::with('categories')->get();
        return view('pages.home',compact('articles'));
    }
}
