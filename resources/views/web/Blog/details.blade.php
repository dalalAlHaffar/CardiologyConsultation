@extends('web.layouts.app')
@section('title', 'Home')
@section('style')
<style>
    body {
    background-color: #fff
}

.container {
    background-color: #eef2f5;
    width: 400px
}

.addtxt {
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: center;
    font-size: 13px;
    width: 350px;
    background-color: #e5e8ed;
    font-weight: 500
}

.form-control: focus {
    color: #000
}

.second {
    width: 350px;
    background-color: white;
    border-radius: 4px;
    box-shadow: 10px 10px 5px #aaaaaa
}

.text1 {
    font-size: 13px;
    font-weight: 500;
    color: #56575b
}

.text2 {
    font-size: 13px;
    font-weight: 500;
    margin-left: 6px;
    color: #56575b
}

.text3 {
    font-size: 13px;
    font-weight: 500;
    margin-right: 4px;
    color: #828386
}

.text3o {
    color: #00a5f4
}

.text4 {
    font-size: 13px;
    font-weight: 500;
    color: #828386
}

.text4i {
    color: #00a5f4
}

.text4o {
    color: white
}

.thumbup {
    font-size: 13px;
    font-weight: 500;
    margin-right: 5px
}

.thumbupo {
    color: #17a2b8
}
</style>
@endsection
@section('content')
<div class="row">
<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $blog->title }}

                @foreach($blog->tags as $hash)
                <button type="button" class="btn btn-outline-secondary" style="border:none; float: right; font-size:small"># {{ $hash->title }}</button>
                @endforeach
            </h5>


            <img src="{{ url('/storage/blog').'/'.$blog->image }}" class="card-img-top" alt="{{ $blog->title }}">
            <div class="row">
                <div class="col-md-2 col-sm-6">
                    <i class="bx bxs-user" style="color:#012970;font-size: 10px;"></i><span class="text-muted" style="font-size:small">{{ ucfirst(optional($blog->user)->name) }}</span>
                </div>
                <div class="col-md-2 col-sm-6">
                    <i class="bx bxs-calendar" style="color:#012970;font-size: 10px;"></i>  <span class="text-muted" style="font-size:small">{{ $blog->created_at->format('M y') }}</span>
                </div>
                <div class="col-md-2 col-sm-6">
                    <i class="ri-eye-fill" style="color:#012970;font-size: 10px;"></i> <span class="text-muted" style="font-size:small">{{ $blog->views }}</span>
                </div>
                <div class="col-md-2 col-sm-6">
                    <i class="bx bx-category" style="color:#012970;font-size: 10px;"></i> <span class="text-muted" style="font-size:small">{{ optional($blog->category)->title }}</span>
                </div>
                <div class="col-md-2 col-sm-6">
                        <i class="bx bxs-comment-detail" style="color:#012970;font-size: 10px;"></i> <span class="text-muted" id="commetCount" style="font-size:small">{{ $blog->comments()->count() }} Comments</span>
                </div>
            </div>
            <p class="card-text">{!! $blog->description !!}</p>

        </div>
      </div>
</div>
  <div class="col-lg-4">
    <!-- News & Updates Traffic -->
    <div class="card">

      <div class="card-body">
        <h5 class="card-title">Most Viewd</span></h5>

        <div class="news">
            @foreach($most_viewed as $vblog)
          <div class="post-item clearfix">
            <a href="{{ url('web/blog').'/'.$vblog->id }}" style="text-decoration: inherit; color: inherit; font-size: inherit; ">
              <div class="row">
                <div class="col-lg-2">
                      <img style="height: 50px;border-radius: 6px" src="{{url('/storage/blog').'/'. $vblog->image }}" alt="{{ $vblog->title }}">
                  </div>
                  <div class="col-lg-8" style="margin-left:30px">
                    <h4 style="color:blue">{{ $vblog->title }}</h4>
                    <p>{{ $vblog->brief_description }}</p>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div><!-- End sidebar recent posts-->

      </div>
    </div><!-- End News & Updates -->
    <div class="container justify-content-center mt-5 border-left border-right" >
       @auth
        <div class="d-flex justify-content-center pt-3 pb-2">
            <input type="text" name="text" id="comment" placeholder="Leave A Comment" class="form-control addtxt">
            <button type="button" class="btn btn-outline-primary" onclick="addComment()"> Add</button>
        </div>
        @endauth
        @guest
        <div class="d-flex justify-content-center pt-3 pb-2 card-title"><a href="{{ route('login') }}">LogIn To Leave A Comment</a></div>
        @endguest

        <div id="commentList">
        @foreach($blog->comments()->orderby('created_at','DESC')->get() as $comment)
        <div class="d-flex justify-content-center py-2">
            <div class="second py-2 px-2">
                <div class="d-flex justify-content-between py-1 pt-2">
                    <div><img src="{{ url('/storage/user').'/'.$comment->user->image}}" width="18"><span class="text2">{{ optional($comment->user)->name }}</span></div>
                </div>
                <span class="text1">{{ $comment->text}}</span>
                <div><span class="text4" style="float:right">{{ $comment->created_at->diffForHumans() }}</span></div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
  </div>

</div>




@endsection
@section('scripts')
<script>
    function addComment(){

$.ajax({
    url: "{{ url('/') }}"+"/web/blog/comment/add",
    data:{
        id : "{{ $blog->id }}",
        text : $('#comment').val(),
        "_token": $('meta[name="csrf-token"]').attr('content')
    },
    type: 'POST',
    success: function(data) {
        console.log(data);
        image = '';
        if(data.result.user.image != null){
            image = "{{ url('/storage/user')}}"+"/"+data.result.user.image;
        }
        list =   '<div class="d-flex justify-content-center py-2">'+
            '<div class="second py-2 px-2">'+
                '<div class="d-flex justify-content-between py-1 pt-2">'+
                   ' <div><img src="'+image+'" width="18"><span class="text2">'+data.result.user.name+'</span></div>'+
                '</div>'+
                '<span class="text1">'+data.result.text+'</span>'+
                '<div><span class="text4" style="float:right">now</span></div>'+
           ' </div>'+
        '</div>';
            $('#commentList').prepend(list);
            document.getElementById("commetCount").innerHTML = data.count+ ' Comments';
            $('#comment').val('');
    },
 });
}

</script>
@endsection
