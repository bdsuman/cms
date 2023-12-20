@extends('layout.app')

@section('content')

    <nav class="navbar sticky-top shadow-sm navbar-expand-lg navbar-light py-2">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img class="img-fluid" src="{{asset('/images/logo.png')}}" alt="" width="96px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header01" aria-controls="header01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="header01">
                <ul class="navbar-nav ms-auto mt-3 mt-lg-0 mb-3 mb-lg-0 me-4">
                    <li class="nav-item me-4"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item me-4"><a class="nav-link" href="#">Company</a></li>
                    <li class="nav-item me-4"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Testimonials</a></li>
                </ul>
                <div><a class="btn mt-3 bg-gradient-primary" href="{{url('/userLogin')}}">Start Blog</a></div>
            </div>
        </div>
    </nav>

        <section class="pb-5 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8 mx-auto text-center">                   
                        <p class="lead text-muted">Spotlight on Our Article</p>
                    </div>
                </div>
                <br/>
                <div class="row">
                @forelse ($articles as $article)                   
                        <div class="col-12 col-md-6 col-lg-3 p-3">
                            <div class="card px-0 text-center">
                                <img class=" card-img-top mb-3 w-100" src="{{asset($article->img_url)}}" alt="">
                                <h5>{{ $article->title }}</h5>
                                <p class="text-muted mb-4">Author: {{ $article->user->firstName }}</p>
                            </div>
                        </div>
                @empty
                        <div class="col-12 col-md-6 col-lg-3 p-3">
                            <div class="card px-0 text-center">
                                <p class="text-danger mb-4">No Data Found</p>
                            </div>
                        </div>
                @endforelse
            </div>
            </div>
        </section>

        <br/>
        <footer class="py-5 bg-light">
            <div class="container text-center pb-5 border-bottom">
                <a class="d-inline-block mx-auto mb-4" href="#">
                    <img class="img-fluid"src="{{asset('/images/logo.png')}}" alt="" width="96px">
                </a>
                <ul class="d-flex flex-wrap justify-content-center align-items-center list-unstyled mb-4">
                    <li><a class="link-secondary me-4" href="#">About</a></li>
                    <li><a class="link-secondary me-4" href="#">Company</a></li>
                    <li><a class="link-secondary me-4" href="#">Services</a></li>
                    <li><a class="link-secondary" href="#">Testimonials</a></li>
                </ul>
                <div>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/facebook.svg')}}">
                    </a>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/twitter.svg')}}">
                    </a>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/github.svg')}}">
                    </a>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/instagram.svg')}}">
                    </a>
                    <a class="d-inline-block" href="#">
                        <img src="{{asset('/images/linkedin.svg')}}">
                    </a>
                </div>
            </div>
            <div class="mb-5"></div>
            <div class="container">
                <p class="text-center">All rights reserved © bdsuman {{ date('Y') }}</p>
            </div>
        </footer>

@endsection
