<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\TblUser as User;


class HomeController extends Controller
{
    public function index()
    {
        // Dashboard data
        $stats = [
            'total_posts' => Post::count(),
            'total_users' => User::count(),
        ];

        $recentPosts = Post::latest()->take(10)->get();

        return view('home', compact('stats', 'recentPosts'));
    }

    public function post_management_pagination()
    {
        // Better than all(): supports pagination
        $post = Post::latest()->paginate(10);
        return view('post.post', compact('post'));
    }

    public function registration_pagination()
    {
        return view('post.posts');
    }
}
