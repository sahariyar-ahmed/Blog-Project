@extends('layouts.master')

@section('content')

<section class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 m-auto">
                <div class="login-content">
                    <h4>Login</h4>
                    <p></p>
                    <form  action="{{route('guest.login')}}" class="sign-form widget-form " method="post">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="E-mail*" name="email" value="">
                            @error('email')
                                <p class="text-danger text-center" >{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password*" name="password" value="">
                            @error('password')
                                <p class="text-danger text-center" >{{$message}}</p>
                            @enderror
                        </div>
                        {{-- <div class="sign-controls form-group">
                            <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                                <label class="custom-control-label" for="rememberMe">Remember Me</label>
                            </div>
                            <a href="#" class="btn-link ">Forgot Password?</a>
                        </div> --}}
                        <div class="form-group">
                            <button type="submit" class="btn-custom">Log in</button>
                        </div>
                        <p class="form-group text-center">Don't have an account? <a href="{{route('guest.register')}}" class="btn-link">Create One</a> </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@if (session('register_success'))
    <script>
        const Toast = Swal.fire({
        position: "top-end",
        icon: "success",
        title: "{{(session('register_success'))}}",
        showConfirmButton: false,
        timer: 1500
        });
    </script>
@endif

@endsection
