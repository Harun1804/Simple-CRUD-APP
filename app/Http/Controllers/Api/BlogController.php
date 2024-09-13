<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Traits\HasImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    use HasImage;

    public function index()
    {
        try {
            $data = Blog::orderByDesc('id')->paginate(10);
            return ResponseFormatter::success($data,'Get Blogs Successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }

    public function store(StoreBlogRequest $request)
    {
        try {
            $image = $request->file('image');
            $this->uploadImage($image, 'blog');

            $slug = Str::slug($request->title);
            $data = Blog::Create([
                'title' => $request->title,
                'body' => $request->body,
                'slug' => $slug,
                'image' => $image->hashName()
            ]);
            return ResponseFormatter::success($data,'Store Blog Successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }

    public function show(Blog $blog)
    {
        try {
            return ResponseFormatter::success($blog,'Get Detail Blog');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        try {
            $slug = Str::slug($request->title);
            $request->request->add(['slug' => $slug]);

            if ($request->hasFile('image') && $request->image != null) {
                $image = $request->file('image');
                $this->updateImage($image, $blog->image, 'blog');
                $blog->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'slug' => $slug,
                    'image' => $image->hashName()
                ]);
            }else{
                $blog->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'slug' => $slug
                ]);
            }
            return ResponseFormatter::success($blog,'Update Blog Successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            $this->removeImage($blog->image, 'blog');
            $blog->delete();
            return ResponseFormatter::success($blog,'Delete Blog Successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }
}
