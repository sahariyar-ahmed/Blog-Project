@extends('layouts.dashboardmaster')

@section('title')
    Blog
@endsection


@section('content')

<x-breadcum bread="Blog create page"></x-breadcum>


<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Create Blog</h4>

                <form role="form" action="{{route('blog.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Categories</label>
                        <div class="col-sm-9">
                            <div class="col-md-6">


                                <select class="form-control" data-toggle="select2" name="category_id">
                                    <option>Select</option>
                                    <optgroup label="{{env('APP_SLOGAN')}}">
                                       @foreach ($categories as $cat)
                                         <option value="{{$cat->id}}">{{$cat->title}}</option>

                                       @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Blog Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputEmail3" placeholder="title" name="title">
                        </div>
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control " id="inputPassword3" placeholder="slug" name="slug">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Blog Short description</label>
                        <div class="col-sm-9">
                            <textarea id="shortNote" type="text" class="form-control @error('short_description') is-invalid @enderror" id="inputEmail3"  name="short_description"></textarea>
                        </div>
                        @error('short_description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Blog description</label>
                        <div class="col-sm-9">
                            <textarea id="longNote" type="text" class="form-control @error('description') is-invalid @enderror" id="inputEmail3"  name="description"></textarea>
                        </div>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-9 d-flex justify-content-center">
                            <img id="hulk" src="{{asset('uploads/default/photo.png')}}" style="width:30%; height=200px; object-fit:contain ">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputPassword5" class="col-sm-3 col-form-label">Thumbnail</label>
                        <div class="col-sm-9">
                            <input onchange="document.querySelector('#hulk').src = window.URL.createObjectURL(this.files[0]) " type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="inputPassword5" name="thumbnail">
                        </div>
                        @error('thumbnail')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="justify-content-end row">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-info waves-effect waves-light">Enter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@endsection

@section('script')
<script>
    tinymce.init({
      selector: '#shortNote',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>

<script>
    tinymce.init({
      selector: '#longNote',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
@endsection

