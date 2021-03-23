@extends('layouts.app')

@section('content')

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Jira - Servicios de N3</h1>
        <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
    </div>
</div>

<div class="container">
    {{-- Search Start --}}
    <div class="row">
        <div class="col-md-12">
            <form>
                <div class="input-group mb-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="Search By post title">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="button-addon2">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Search End --}}
    <div class="row ">

        <div class="col-md-8 ">
            <div class="container-fluid px-0">
                <div class="row ">
                    @forelse ($posts as $post)
                    <div class="col-md-12 mb-3 ">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ $post->image_url }}" class="img-fluid mb-3" alt="Post Image">
                                <h3>{{ $post->title }}</h3>
                                <p>Post <small><i>{{ $post->date }}</i></small> by <b>{{ $post->user->name }}</b></p>
                                <p>{{ Str::limit($post->content, 400, '...') }}</p>
                                <a href="{{ url("post/$post->id") }}" class="btn btn-primary">View Detail &raquo;</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <h3>There is no posts.</h3>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h3>Category</h3>
            <ul>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ url("/?category=$category->id") }}" class="btn btn-link">
                            {{ $category->name }} ({{ $category->posts->count() }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $posts->appends(['search'=>request('search'), 'category'=>request('category')])->links() }}
        </div>
    </div>
</div>
@endsection