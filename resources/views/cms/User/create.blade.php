@extends('cms.layouts.app')
@section('title', 'Add User')
@section('style')

@endsection
@section('content')
<section class="section">
  <div class="row  justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add User</h5>
          <!-- General Form Elements -->
          <form action="{{url('cms/user')}}" method="POST" enctype='multipart/form-data' class="needsValidation">
            @csrf
            <x-input>
              <x-slot name="label">Name</x-slot>
              <x-slot name="type">text</x-slot>
              <x-slot name="name">name</x-slot>
              <x-slot name="id">yourName</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>
            <x-input>
              <x-slot name="label">Email</x-slot>
              <x-slot name="type">email</x-slot>
              <x-slot name="name">email</x-slot>
              <x-slot name="id">yourEmail</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>
            <x-input>
              <x-slot name="label">Password</x-slot>
              <x-slot name="type">password</x-slot>
              <x-slot name="name">password</x-slot>
              <x-slot name="id">yourPassword</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <select class="form-select @error('role') laravel-invalied @enderror" placeholder="bla" name="role" aria-label="Default select example">
                  <option value="admin">Admin</option>
                  <option value="customer">Customer</option>
                </select>
                @error('role')
                <div id="alert-category_id" class="laravel-invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <x-input>
              <x-slot name="label">Image</x-slot>
              <x-slot name="type">file</x-slot>
              <x-slot name="name">image</x-slot>
              <x-slot name="id">yourImage</x-slot>
              <x-slot name="forLogin">no</x-slot>
            </x-input>

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
    initSelect2($('select[name="category_id"]'), "{{url('/')}}" + '/cms/categories/select')
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#yourPassword');

    togglePassword.addEventListener('click', function(e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('ri-eye-fill');
    });


  });
</script>


@endsection