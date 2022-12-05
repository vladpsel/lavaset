<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class AppPostController extends Controller
{
    public function posts()
    {
        $posts = Post::where([
            ['locale', '=', app()->getLocale()],
            ['is_visible', '=', 1]
        ])->orderBy('updated_at', 'desc')->get();

        return view('app.posts.index', [

            'items' => $posts,
        ]);
    }

    public function single($id)
    {
        $post = Post::where([
            ['locale', '=', app()->getLocale()],
            ['alias', '=', $id],
            ['is_visible', '=', 1]
        ])->first();

        if (!$post || empty($post)) {
            return abort(404);
        }

        return view('app.posts.single', [
            'post' => $post,
        ]);
    }
}
