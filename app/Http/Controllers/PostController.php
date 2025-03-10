<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postData = $request->validated();

        $post = Post::create($postData);

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')->withResponsiveImages()
                ->usingName($post->title)
                ->toMediaCollection('images');
        }

        if ($request->hasFile('download')) {
            $post->addMediaFromRequest('download')->withResponsiveImages()
                ->usingName($post->title)
                ->toMediaCollection('downloads');
        }

        return to_route('posts.index')->with('success', "Post '$post->title' created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $postData = $request->validated();

        $post->update($postData);

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')->withResponsiveImages()
                ->usingName($post->title)
                ->toMediaCollection('images');
        }

        if ($request->hasFile('download')) {
            $post->addMediaFromRequest('download')->withResponsiveImages()
                ->usingName($post->title)
                ->toMediaCollection('downloads');
        }

        return to_route('posts.index')->with('success', "Post '$post->title' created successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('posts.index')->with('success', 'Post deleted successfully');
    }

    public function download(Post $post)
    {
        $media = $post->getFirstMedia('downloads');

        return $media;
    }

    public function downloads()
    {
        $media = Media::where('collection_name', 'downloads')->get();

        return MediaStream::create('downloads.zip')->addMedia($media);
    }

    public function downloadAllMedia()
    {
        return MediaStream::create('downloadsAll.zip')->addMedia(Media::all());
    }

    public function resImage(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
