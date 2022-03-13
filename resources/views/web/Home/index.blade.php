@extends('web.layouts.app')
@section('title', 'Home')

@section('content')
<div class="row">
@foreach ($blogs as $blog )
<div class="col-md-4 col-sm-6">
<div class="card">
    <a href="{{ url('/').'/'.'web/blog/'.$blog->id }}">
    <img src="{{ url('/storage/blog').'/'.$blog->image }}" class="card-img-top" alt="{{ $blog->title }}">
    </a>
    <div class="card-body">
     <a href="{{ url('/').'/'.'web/blog/'.$blog->id }}" style="color:inherit">
        <h5 class="card-title">{{ $blog->title }}</h5>
        <p class="card-text">{{ $blog->brief_description }}</p>
     </a>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <i class="bx bxs-user" style="color:#012970;font-size: 10px;"></i><span class="text-muted" style="font-size:small">{{ ucfirst($blog->user->name) }}</span>
            </div>
            <div class="col-md-4 col-sm-6">
                <i class="bx bxs-calendar" style="color:#012970;font-size: 10px;"></i>  <span class="text-muted" style="font-size:small">{{ $blog->created_at->format('M y') }}</span>
            </div>
            <div class="col-md-4 col-sm-6">
                <i class="ri-eye-fill" style="color:#012970;font-size: 10px;"></i> <span class="text-muted" style="font-size:small">{{ $blog->views }}</span>
            </div>
            <div class="col-md-4 col-sm-6">
                <i class="ri-eye-fill" style="color:#012970;font-size: 10px;"></i> <span class="text-muted" style="font-size:small">{{ $blog->views }}</span>
            </div>
        </div>

    </div>
  </div>
</div>
@endforeach
{{ $blogs->links('web.layouts.pagination') }}
</div>

@endsection
