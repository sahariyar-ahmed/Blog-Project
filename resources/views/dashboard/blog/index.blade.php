@extends('layouts.dashboardmaster')

@section('title')
    Blog
@endsection

@section('content')

<x-breadcum bread="Blog show page" ></x-breadcum>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Blog's Table</h4>
                <p class="sub-header">
                    Use one of two modifier classes to make <code>&lt;thead&gt;</code>s appear light or dark gray.
                </p>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category title</th>
                                <th>Status</th>
                                <th>feature</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $blogs as $blog )
                            <tr>
                                <th scope="row">
                                    {{$loop->index + 1}}
                                </th>
                                <td>
                                    <img src="{{asset('uploads/blog')}}/{{ $blog->thumbnail }} "style="width:80px; height:80px;">
                                </td>
                                <td>{{ $blog->title }}</td>


                                <td>
                                    <form id="hulk{{ $blog->id }}"
                                        action="{{ route('blog.change_status', $blog->id) }}" method="POST">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input
                                                onchange="document.querySelector('#hulk{{ $blog->id }}').submit()"
                                                class="form-check-input" type="checkbox" role="switch"
                                                id="flexSwitchCheckChecked"
                                                {{ $blog->status == 'active' ? 'checked' : '' }}>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form id="smash{{ $blog->id }}"
                                        action="{{ route('blog.feature', $blog->id) }}" method="POST">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input
                                                onchange="document.querySelector('#smash{{ $blog->id }}').submit()"
                                                class="form-check-input" type="checkbox" role="switch"
                                                id="flexSwitchCheckChecked"
                                                {{ $blog->feature == true ? 'checked' : '' }}>

                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showRifat{{$blog->id}}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{route('blog.edit',$blog->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form class="d-inline-block" action="{{ route('blog.destroy', $blog->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="showRifat{{$blog->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{$blog->id}} - {{$blog->title}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <h2>Title - {{$blog->title}}</h2>
                                    <p>Description - {!! $blog->description !!}</p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                        {{ $blogs->links() }}
                    </table>
                </div> <!-- end table-responsive-->
            </div>
        </div> <!-- end card -->
    </div>
</div>

@endsection

@section('script')
@if (session('success'))


<script>
    Toastify({
    text: "{{session('success')}}",
    duration: 3000,
    newWindow: true,
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "right", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    style: {
        background: "linear-gradient(to right, #00b09b, #96c93d)",
    },
    onClick: function(){} // Callback after click
    }).showToast();
</script>
@endif

@endsection
