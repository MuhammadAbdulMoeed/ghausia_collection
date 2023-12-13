<?php

namespace App\Http\Controllers;

use App\Helper\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\User;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::getAllPost();
        // return $posts;
        return view('backend.post.index')->with('posts', $posts);
    }

    public function create()
    {
        $categories = PostCategory::get();
        $tags = PostTag::get();
        $users = User::get();
        return view('backend.post.create')->with('users', $users)->with('categories', $categories)->with('tags', $tags);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'quote' => 'string|nullable',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'sometimes|mimes:jpeg,jpg,png',  //'string|nullable',
            'tags' => 'nullable',
            'added_by' => 'nullable',
            'post_cat_id' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();

        $slug = Str::slug($request->title);
        $count = Post::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;

        $tags = $request->input('tags');
        if ($tags) {
            $data['tags'] = implode(',', $tags);
        } else {
            $data['tags'] = '';
        }
        // return $data;
        $data['photo'] = null;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status = Post::create($data);
        if ($status) {
            request()->session()->flash('success', 'Post Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('post.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = PostCategory::get();
        $tags = PostTag::get();
        $users = User::get();
        return view('backend.post.edit')->with('categories', $categories)->with('users', $users)->with('tags', $tags)->with('post', $post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'quote' => 'string|nullable',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'sometimes|mimes:jpeg,jpg,png',  //'string|nullable',
            'tags' => 'nullable',
            'added_by' => 'nullable',
            'post_cat_id' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $tags = $request->input('tags');
        // return $tags;
        if ($tags) {
            $data['tags'] = implode(',', $tags);
        } else {
            $data['tags'] = '';
        }
        // return $data;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
                if (isset($post->photo)) {
                    if (file_exists(public_path($post->photo))) {
                        unlink(public_path($post->photo));
                    }
                }
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status = $post->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Post Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('post.index');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $status = $post->delete();

        if ($status) {
            request()->session()->flash('success', 'Post successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting post ');
        }
        return redirect()->route('post.index');
    }
}
