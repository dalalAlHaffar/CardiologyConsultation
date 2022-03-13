@extends('cms.layouts.app')
@section('title', 'Edit Category')
@section('style')

@endsection
@section('content')
<section class="section">
  <div class="row  justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Category</h5>
          <!-- General Form Elements -->
          <form action="{{url('cms/category/').'/'.$category->id}}" method="POST" enctype='multipart/form-data' class="needsValidation">
            @csrf
            @method('PUT')
            <x-input>
              <x-slot name="label">Title</x-slot>
              <x-slot name="type">text</x-slot>
              <x-slot name="name">title</x-slot>
              <x-slot name="id">yourTitle</x-slot>
              <x-slot name="forLogin">no</x-slot>
              <x-slot name="value">{{$category->title}}</x-slot>
            </x-input>
            <x-input>
              <x-slot name="label">Image</x-slot>
              <x-slot name="type">file</x-slot>
              <x-slot name="name">image</x-slot>
              <x-slot name="id">yourImage</x-slot>
              <x-slot name="forLogin">no</x-slot>
              <x-slot name="required">false</x-slot>
            </x-input>

            <div class="row mb-3 justify-content-center">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary">UPDATE</button>
              </div>
            </div>

          </form><!-- End General Form Elements -->

        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js" defer></script>

<script>
  ClassicEditor
    .create(document.querySelector('#yourDescription'))
    .catch(error => {
      console.error(error);
    });
  $(document).ready(function() {
    $('#tags').select2({
      tags: true
    });

  });
</script>


@endsection