<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use Illuminate\Http\Request;

class WebPostController extends Controller
{
    public function index()
    {
        $allPost = PostModel::all();
        return view('posts.all', ['posts' => $allPost]);
    }
}
