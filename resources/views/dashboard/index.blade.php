@extends('layouts.app')

@section('content')
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Home Page</h1>
                <p class="lead text-muted">Great Stories from Our Authors</p>
                <p>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-primary my-2">All</a>
                    <a href="{{ route('dashboard.index', ['type' => 'short']) }}" class="btn btn-secondary my-2">Short</a>
                    <a href="{{ route('dashboard.index', ['type' => 'long']) }}" class="btn btn-secondary my-2">Long</a>
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach( $stories as $story)
                <div class="col">
                    <div class="card shadow-sm">
                        <a href="{{ route('dashboard.show', [$story] ) }}">
                            <img class="card-img-top" src="{{ $story->thumbnail}}" alt="Card image cap">
                        </a>

{{--                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" src="{{ $story->thumbnail}}"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>--}}

                        <div class="card-body">
                            <p class="card-text">{{ $story->title }}</p>

{{--                            display tags--}}
                            <br />
                            @foreach( $story->tags as $tag)
                                <button class="btn btn-sm btn-outline-primary">{{$tag->name}}</button>
                            @endforeach

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">{{ $story->user->name}}</button>
{{--                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>--}}
                                </div>
                                <small class="text-muted">{{ $story->type}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $stories->withQueryString()->links() }}
        </div>
    </div>




    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

@endsection
{{--{{dd(DB::getQueryLog())--}}


