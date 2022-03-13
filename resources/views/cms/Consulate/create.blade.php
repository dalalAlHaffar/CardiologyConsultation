@extends('cms.layouts.app')
@section('title', 'Add Blog')
@section('style')

@endsection
@section('content')
<section class="section">
  <div class="row  justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Blog</h5>
          <!-- General Form Elements -->
          <form action="{{url('cms/blog')}}" method="POST" enctype='multipart/form-data' class="needsValidation">
            @csrf
            <x-input>
              <x-slot name="label">Title</x-slot>
              <x-slot name="type">text</x-slot>
              <x-slot name="name">title</x-slot>
              <x-slot name="id">yourTitle</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>
            <x-input>
              <x-slot name="label">Description</x-slot>
              <x-slot name="type">textarea</x-slot>
              <x-slot name="name">description</x-slot>
              <x-slot name="id">yourDescription</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>
            <x-input>
              <x-slot name="label">Brief Description</x-slot>
              <x-slot name="type">textarea</x-slot>
              <x-slot name="name">brief_description</x-slot>
              <x-slot name="id">yourBriefDescription</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>
            <x-input>
              <x-slot name="label">Image</x-slot>
              <x-slot name="type">file</x-slot>
              <x-slot name="name">image</x-slot>
              <x-slot name="id">yourImage</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Category</label>
              <div class="col-sm-10">
                <select class="form-select select2 @error('category_id') laravel-invalied @enderror" placeholder="bla" name="category_id" aria-label="Default select example">
                </select>
                @error('category_id')
                <div id="alert-category_id" class="laravel-invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Tags</label>
              <div class="col-sm-10">
                <select id="tags" name="tags[]" class="form-select select2 @error('tags') laravel-invalied @enderror" multiple>
                </select>
                @error('tags')
                <div id="alert-tags" class="laravel-invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3 justify-content-center">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary">ADD</button>
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
<script src="{{url('assets/js/select2Helper.js')}}"></script>
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
    initSelect2($('select[name="category_id"]') ,"{{url('/')}}"+'/cms/categories/select')
  });
</script>


@endsection