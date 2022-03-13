@extends('web.layouts.app')
@section('title', 'Consultaion')

@section('style')
<style>
*, *::before, *::after{
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}


.container{
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items:center;
  background: #f3f3f3;
}

.card{
  width: 25rem;
  border-radius: 1rem;
  background: white;
  box-shadow: 4px 4px 15px rgba(#000, 0.15);
  position : relative;
  color: #434343;
}

.card .card__container{
  padding : 2rem;
  width: 100%;
  height: 100%;
  background: white;
  border-radius: 1rem;
  position: relative;
}

.card .card__header{
  margin-bottom: 1rem;
}

.card-label::before{

  position: absolute;
  bottom:1.6rem;
  right:-0.5rem;
  content: '';
  background: #283593;
  height: 28px;
  width: 28px;
  transform : rotate(45deg);
}

.card-label::after{
  border-top-left-radius: 19px;
  border-bottom-left-radius: 19px;
  bottom: 0rem;
  position: absolute;
  content: attr(data-label);
  right: -14px;
  padding: 0.5rem;
  width: 6rem;
  background: #3949ab;
  color: white;
  text-align: center;
  font-family: 'Roboto', sans-serif;
  box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
}
</style>
@endsection
@section('content')
<section class="section dashboard">
  <a href="{{url('/web/consolute/create')}}" class="btn btn-primary" style=" float: right; margin-top: -60px; ">Add</a>
  <div class="row">
    @foreach ($Consulates as $Consulate )
    <div class="col-md-4 col-sm-6">
      <div class="card info-card revenue-card  @if( $Consulate->answer != null) card-label @endif" data-label="Answered"> 
        <div class="filter" style=" z-index: 1;">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Actions</h6>
            </li>
            @if( $Consulate->answer != null)
            <li><a class="dropdown-item open-Answer" data-bs-toggle="modal" data-answer="{{$Consulate->answer}}" data-bs-target="#basicModal" href="#">Answer</a></li>
            @else
            <li><a class="dropdown-item" href="{{ url('/web/consolute/'.$Consulate->id.'/edit') }}">Edit</a></li>
            <li><a class="dropdown-item" onclick="Delete('{{$Consulate->id}}')" href="#">Delete</a></li>
            @endif
          </ul>
        </div>
        <div class="card-body card__container">
          <h5 class="card-title card__header">{{ $Consulate->title }}</h5>
          <p class="card-text d-flex align-items-center card__body">{!! $Consulate->description !!}</p>
        </div>
      </div>
    </div>
    @endforeach
    {{ $Consulates->links('web.layouts.pagination') }}
  </div>

  <div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="card-title " style="padding: 0px">Answer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="answer"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->

</section>
@endsection

@section('scripts')
<script>
  function Delete(id) {
    deleteUrl = "{{ url('/') }}" + "/web/consolute/" + id
    fireSwal(deleteUrl);
  }
  $(document).on("click", ".open-Answer", function() {
    var answer = $(this).data('answer');
    p = document.getElementById('answer');
    p.textContent = answer;
  });
</script>
@endSection