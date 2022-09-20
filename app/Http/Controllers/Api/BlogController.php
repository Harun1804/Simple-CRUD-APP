<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $data = Blog::orderByDesc('id')->get();
            return ResponseFormatter::success($data,'Get Blogs Successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:blogs',
            'body'  => 'required'
        ]);

        if($validator->fails()){
            return ResponseFormatter::error($validator->errors());
        }else{
            try {
                $slug = Str::slug($request->title);
                $request->request->add(['slug' => $slug]);
                $data = Blog::Create($request->all());
                return ResponseFormatter::success($data,'Store Blog Successfully');
            } catch (\Exception $e) {
                return ResponseFormatter::error("",$e->getMessage());
            }
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

    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:blogs,title,'.$blog->id,
            'body'  => 'required'
        ]);

        if($validator->fails()){
            return ResponseFormatter::error($validator->errors());
        }else{
            try {
                $slug = Str::slug($request->title);
                $request->request->add(['slug' => $slug]);
                $blog->update($request->all());
                return ResponseFormatter::success($blog,'Update Blog Successfully');
            } catch (\Exception $e) {
                return ResponseFormatter::error("",$e->getMessage());
            }
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            return ResponseFormatter::success($blog,'Delete Blog Successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error("",$e->getMessage());
        }
    }
}
