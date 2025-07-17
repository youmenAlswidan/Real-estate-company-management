<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Real Estate Company Mahagement
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
       
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-black text-dark display-6">Welcome back</h3>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="{{ route('login')}}">
                   @csrf
                    <label>Email Address</label>
                    <div class="mb-3">
                      <input id="email" name="email" type="email" class="form-control" placeholder="Enter your email address"  @error('email') is-invalid @enderror 
                        value="{{ old('email') }}" aria-label="Email" aria-describedby="email-addon" autofocus required>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input id="password" name="password" type="password" class="form-control" @error('password') is-invalid @enderror
                      placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required>

                      @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror

                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8" style="background-image:url('../assets/img/image-sign-in.jpg')">
                  <div class="blur mt-12 p-4 text-center border border-white border-radius-md position-absolute fixed-bottom m-4">
                    <h6 class="text-dark text-sm mt-5">Copyright © 2025 Corporate UI Design System by Creative Tim.</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  
</body>

</html>