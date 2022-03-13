@extends('web.layouts.app')
@section('title', 'Edit Consultation')
@section('style')

@endsection
@section('content')
<section class="section">
  <div class="row  justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Consultation</h5>
          <!-- General Form Elements -->
          <form action="{{url('web/consolute/$Consulate->id')}}" method="POST" enctype='multipart/form-data' class="needsValidation">
            @csrf
            @method('PUT')
            <x-input>
              <x-slot name="label">Title</x-slot>
              <x-slot name="type">text</x-slot>
              <x-slot name="name">title</x-slot>
              <x-slot name="id">yourTitle</x-slot>
              <x-slot name="forLogin">no</x-slot>
              <x-slot name="value">{{ $Consulate->title }}</x-slot>
            </x-input>

            <x-input>
              <x-slot name="label">Description</x-slot>
              <x-slot name="type">textarea</x-slot>
              <x-slot name="name">description</x-slot>
              <x-slot name="id">yourDescription</x-slot>
              <x-slot name="forLogin">no</x-slot>
              <x-slot name="value">{{ $Consulate->description }}</x-slot>
            </x-input>

            <x-input>
                <x-slot name="label">Medical history</x-slot>
                <x-slot name="type">textarea</x-slot>
                <x-slot name="name">medical_history</x-slot>
                <x-slot name="id">yourmedical_history</x-slot>
                <x-slot name="forLogin">no</x-slot>
                <x-slot name="value">{{ $Consulate->medical_history }}</x-slot>
              </x-input>

              <x-input>
                <x-slot name="label">Name</x-slot>
                <x-slot name="type">text</x-slot>
                <x-slot name="name">name</x-slot>
                <x-slot name="id">yourName</x-slot>
                <x-slot name="forLogin">no</x-slot>
                <x-slot name="value">{{ auth()->user()->name }}</x-slot>
              </x-input>

              <x-input>
                <x-slot name="label">Email</x-slot>
                <x-slot name="type">email</x-slot>
                <x-slot name="name">email</x-slot>
                <x-slot name="id">yourEmail</x-slot>
                <x-slot name="forLogin">no</x-slot>
                <x-slot name="readOnly">yes</x-slot>
                <x-slot name="value">{{ auth()->user()->email }}</x-slot>
              </x-input>
              <x-input>
                <x-slot name="label">Phone</x-slot>
                <x-slot name="type">phone</x-slot>
                <x-slot name="name">phone</x-slot>
                <x-slot name="id">yourPhone</x-slot>
                <x-slot name="forLogin">no</x-slot>
                <x-slot name="value">{{ auth()->user()->phone }}</x-slot>
              </x-input>

              <x-input>
                <x-slot name="label">Age</x-slot>
                <x-slot name="type">number</x-slot>
                <x-slot name="name">age</x-slot>
                <x-slot name="id">yourAge</x-slot>
                <x-slot name="forLogin">no</x-slot>
                <x-slot name="value">{{auth()->user()->age }}</x-slot>
              </x-input>
              <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                <div class="col-sm-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="male" @if(auth()->user()->gender == "male") checked @endif>
                    <label class="form-check-label" for="gridRadios1">
                     Male
                    </label>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="female" @if(auth()->user()->gender == "female") checked @endif>
                    <label class="form-check-label" for="gridRadios2">
                      Female
                    </label>
                  </div>
                </div>
              </fieldset>

              <div class="row mb-3">
                <label class="col-form-label col-sm-2 pt-0"></label>
                <div class="col-sm-3">
                    {!! captcha_img() !!}
                </div>
                <div class="col-sm-3">
                    <input class="form-control" type="text" name="captcha">
                    @error('captcha')
                    <div id="alert-captcha" class="laravel-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            <div class="row mb-3 justify-content-center">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary">Update</button>
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
