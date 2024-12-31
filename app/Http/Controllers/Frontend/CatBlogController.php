<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\category;
use Illuminate\Http\Request;
use App\Models\BlogComment;

class CatBlogController extends Controller
{
    public function show($slug){
        $category = Category::where("slug",$slug)->first();
        $blogs = Blog::where('category_id',$category->id)->latest()->paginate(5);

        return view('frontend.category.index',compact('category','blogs'));
    }

    public function single($slug){
        $blog = Blog::where('slug',$slug)->first();
        $comments = BlogComment::with('replies')->where('blog_id',$blog->id)->whereNull('parent_id')->get();
        return view('frontend.blog.single',compact('blog','comments'));
    }


}
