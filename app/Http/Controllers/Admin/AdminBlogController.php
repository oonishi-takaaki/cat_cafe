<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Cat;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminBlogController extends Controller
{
    //ブログの一覧
    public function index()
    {
        $blogs = Blog::latest('created_at')->paginate(10);
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    //ブログの投稿画面
    public function create()
    {
        $categories = Category::all();
        $cats = Cat::all();
        return view('admin.blogs.create', ['categories' => $categories, 'cats' => $cats]);
    }

    //ブログの投稿
    public function store(StoreBlogRequest $request)
    {
        // $validated = $request->validated();
        // $validated['image'] = $request->file('image')->store('blogs', 'public');
        // Blog::create($validated);



        $savedImagePath = $request->file('image')->store('blogs', 'public');
        $blog = new Blog($request->validated());
        $blog->image = $savedImagePath;
        $blog->category()->associate($request['category_id']);
        $blog->cats()->sync($request['cats'] ?? []);
        $blog->save();

        return to_route('admin.blogs.index')->with('success', 'ブログを投稿しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    //指定したIDのブログの編集
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $cats = Cat::all();
        $user = Auth::user();
        return view('admin.blogs.edit', ['blog' => $blog, 'categories' => $categories, 'cats' => $cats, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $updateData = $request->validated();

        //画像を変更する場合
        if ($request->has('image')) {
            //変更前の画像を削除
            Storage::disk('public')->delete($blog->image);

            //変更後の画像のアップデート
            $updateData['image'] = $request->file('image')->store('blogs', 'public');
        }
        $blog->category()->associate($updateData['category_id']);
        $blog->cats()->sync($updateData['cats'] ?? []);
        $blog->update($updateData);

        return to_route('admin.blogs.index')->with('success', 'ブログを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        Storage::disk('public')->delete($blog->image);

        return to_route('admin.blogs.index')->with('success', 'ブログを削除しました。');
    }
}
