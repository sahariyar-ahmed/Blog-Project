<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(5);
        return view("dashboard.blog.index",compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where("status","active")->latest()->get();
        return view("dashboard.blog.create",compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());
        $request->validate([
            'category_id' =>'required',
            'thumbnail' =>'required',
            'title' =>'required',
            'short_description' =>'required|max:1000',
            'description' =>'required',
        ]);

        if ($request->hasFile('thumbnail')) {
           $newname = Auth::user()->id . '-' . Str::random(4). '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(base_path('public/uploads/blog/'.$newname));

            if($request->slug){
                Blog::create([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category_id,
                    'thumbnail' => $newname,
                    'title' => $request->title,
                    'slug' => Str::slug($request->slug,'-') ,
                    'short_description' => $request->short_description,
                    'description' => $request->description,

                ]);
                return redirect()->route('blog.index')->with('success','Blog creation successful');
            }else{
                Blog::create([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category_id,
                    'thumbnail' => $newname,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title,'-') ,
                    'short_description' => $request->short_description,
                    'description' => $request->description,

                ]);
                return redirect()->route('blog.index')->with('success','Blog creation successful');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = Category::where('status','active')->latest()->get();
        return view('dashboard.blog.edit', compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {

        $manager = new ImageManager(new Driver());
        $request->validate([
            'category_id' =>'required',
            'thumbnail' =>'required',
            'title' =>'required',
            'short_description' =>'required|max:300',
            'description' =>'required',
        ]);

        if ($request->hasFile('thumbnail')) {
           $newname = Auth::user()->id . '-' . Str::random(4). '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $image = $manager->read($request->file('thumbnail'));
            $image->toPng()->save(base_path('public/uploads/blog/'.$newname));

            if($request->slug){
                Blog::find($blog->id)->update([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category_id,
                    'thumbnail' => $newname,
                    'title' => $request->title,
                    'slug' => Str::slug($request->slug,'-') ,
                    'short_description' => $request->short_description,
                    'description' => $request->description,

                ]);
                return redirect()->route('blog.index')->with('success','Blog Update successful');
            }else{
                Blog::find($blog->id)->update([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category_id,
                    'thumbnail' => $newname,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title,'-') ,
                    'short_description' => $request->short_description,
                    'description' => $request->description,

                ]);
                return redirect()->route('blog.index')->with('success','Blog Update successful');
            }
        }else{

            if($request->slug){
                Blog::find($blog->id)->update([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'slug' => Str::slug($request->slug,'-') ,
                    'short_description' => $request->short_description,
                    'description' => $request->description,

                ]);
                return redirect()->route('blog.index')->with('success','Blog Update successful');
            }else{
                Blog::find($blog->id)->update([
                    'user_id' => Auth::user()->id,
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'slug' => Str::slug($request->title,'-'),
                    'short_description' => $request->short_description,
                    'description' => $request->description,

                ]);
                return redirect()->route('blog.index')->with('success','Blog Update successful');
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        Blog::find($blog->id)->delete();
        return redirect()->route('blog.index')->with('success', 'Blog Updated Successful');

    }

    public  function status(Blog $blog,  Request $request)
    {
        if ($blog->status == 'active') {
            $blog->update([
                'status' => 'deactive',
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Blog Status Successfully Update');
        } else {
            $blog->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Blog Status Successfully Update');
        }
    }


    public function feature($id)
    {
        $blog = Blog::where('id', $id)->first();
        if ($blog->feature == false) {
            Blog::find($blog->id)->update([
                'feature' => true,
                'updated_at'=> now(),
            ]);
            return redirect()->route('blog.index')->with('success', value: 'Blog featured now ');

        }else{
            Blog::find($blog->id)->update([
                'feature' => false,
                'updated_at'=> now(),
            ]);
            return redirect()->route('blog.index')->with('success', value: 'Blog not featured now ');
        }

    }


}
