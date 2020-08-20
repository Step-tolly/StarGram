<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
         'caption' => ['required', 'string'],
         'image' => ['required', 'image']
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath       // on ne peut pas mettre $data['image'] car c est un chemin temporaire et pas le chemin effectif de l'image
        ]);

        return redirect()->route('profiles.show', ['user' => auth()->user()]);
    }
}
