@extends('admin.layouts.master')

@section('title', 'Post All')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('message.alert')
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @can('create post')
            <a href="{{ url('admin/post/create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus-circle"></i> Create
            </a>
            @endcan
        </div>
        <div class="col-md-6">
            <form>
                <div class="input-group input-group" >
                    <input type="text" name="search" class="form-control float-right" placeholder="Search">
                    
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        @foreach ($posts as $post)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ $post->title }}
                    </div>
                    <div class="card-body">
                        {{-- {{ strlen($post->content) > 100 ? substr($post->content, 0, 100) . '***' :  $post->content}} --}}
                        {{-- {{ Str::limit($post->content, 200, '...') }} --}}
                        {{ Str::limit($post->content, 200) }}
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{ url("admin/post/$post->id") }}" class="btn btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('edit post')
                            <a href="{{ url("admin/post/$post->id/edit") }}" class="btn btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan 
                            @can('delete post')
                            <a href="{{ url("admin/post/$post->id/delete") }}" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12">
            {{ $posts->links() }}
        </div>
    </div>
</div>

@endsection