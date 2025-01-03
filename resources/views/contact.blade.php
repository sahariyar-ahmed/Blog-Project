@extends('layouts.master')
@section('content')


      <!--section-heading-->
     <div>
        <div class="section-heading " >
            <div class="container-fluid">
                 <div class="section-heading-2">
                     <div class="row">
                         <div class="col-lg-12">
                             <div class="section-heading-2-title">
                                 <h1>Contact us</h1>
                                 <p class="links"><a href="{{route('frontend')}}">Home <i class="las la-angle-right"></i></a> Contact</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
        </div>
     </div>

    <!--contact-->
    <section class="contact">
        <div class="container-fluid">
            <div class="contact-area">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-image">
                            <img src="{{asset('frontend')}}/assets/img/other/contact.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-info">
                            <h3>feel free to contact us</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate deserunt suscipit error deleniti
                                porro, pariatur voluptatem iste quos maxime aspernatur.</p>
                        </div>

                        <!--form-->
                        <form action="{{route('contact.submit')}}" class="form contact_form " method="POST" id="main_contact_form">
                            @csrf
                            <div class="alert alert-success contact_msg" style="display: none" role="alert" >
                                Your message was sent successfully.
                            </div>
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name*" value="{{ old('name') }}" >
                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email*" value="{{ old('email') }}" >
                                @error('email')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Message*">{{ old('message') }}</textarea>
                                @error('message')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                {!! NoCaptcha::display() !!}
                            </div>
                            <button type="submit" name="submit" class="btn-custom">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>





