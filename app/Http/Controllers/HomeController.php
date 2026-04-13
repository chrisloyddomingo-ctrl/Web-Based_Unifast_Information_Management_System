<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\TblUser as User;
use App\Models\Application;
use App\Models\Grantee;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_grantees'       => Grantee::count(),
            'total_posts'          => Post::count(),
            'total_users'          => User::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'total_attendance'     => Event::count(),
            'approved_applications'=> Application::where('status', 'approved')->count(),
        ];

        $recentPosts = Post::latest()->take(10)->get();

        return view('home', compact('stats', 'recentPosts'));
    }

    public function post_management_pagination()
    {
        $post = Post::latest()->paginate(10);
        return view('post.post', compact('post'));
    }

    public function registration_pagination()
    {
        return view('post.posts');
    }
}