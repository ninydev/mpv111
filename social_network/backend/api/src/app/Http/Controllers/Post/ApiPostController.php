<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use Illuminate\Http\Request;

class ApiPostController extends Controller
{
    public function index()
    {
        $allPost = PostModel::all();
        return response()->json($allPost, 200);
    }
}
