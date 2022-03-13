<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ url('assets/img/favicon.png')}}" rel="icon">
  <link href="{{ url('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ url('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ url('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ url('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{ url('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{ url('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ url('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ url('assets/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="{{ url('assets/img/logo.png')}}" alt="">
                  <span class="d-none d-lg-block">{{env('APP_NAME')}}</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your Email & password to login</p>

                  </div>

                  <form method="POST" action="{{ url('login') }}" novalidate class="row g-3 needs-validation ">
                    @csrf


                    <x-input>
                      <x-slot name="label">Email</x-slot>
                      <x-slot name="type">email</x-slot>
                      <x-slot name="name">email</x-slot>
                      <x-slot name="id">yourEmail</x-slot>
                      <x-slot name="forLogin">yes</x-slot>
                    </x-input>

                    <x-input>
                      <x-slot name="label">Password</x-slot>
                      <x-slot name="type">password</x-slot>
                      <x-slot name="name">password</x-slot>
                      <x-slot name="id">yourPassword</x-slot>
                      <x-slot name="forLogin">yes</x-slot>
                    </x-input>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account?  <a href="{{url('register')}}">Create an Account</a></p>
                    </div>
                  </form>
                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="#">{{env('APP_NAME')}}</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>




  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ url('assets/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{ url('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ url('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ url('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ url('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ url('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ url('assets/js/main.js')}}"></script>
<script>
        $(document).ready(function() {
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
</body>

</html>
