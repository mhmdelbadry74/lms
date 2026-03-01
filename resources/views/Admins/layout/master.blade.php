<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
  @include("Admins.layout.parts.head")
  @stack("styles")
  <body> 
    {{-- <div class="loader-wrapper"> 
      <div class="loader loader-1">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner-1"></div>
      </div>
    </div> --}}
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <div class="page-header row">
        <div class="header-logo-wrapper col-auto">
          <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light" src=".{{asset('assets/images/logo/logo.png')}}" alt=""/><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_light.png')}}" alt=""/></a></div>
        </div>
        <div class="col-4 col-xl-4 page-title">
          <h4 class="f-w-700">Sample Page</h4>
          <nav>
            <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
              <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"> </i></a></li>
              <li class="breadcrumb-item f-w-400">Pages</li>
              <li class="breadcrumb-item f-w-400 active">Sample Page</li>
            </ol>
          </nav>
        </div>
        @include("Admins.layout.parts.header")
      </div>
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        @include("Admins.layout.parts.sidebar")
        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
           @yield("content")
          </div>
          <!-- Container-fluid Ends-->
        </div>
        @include("Admins.layout.parts.footer")
      </div>
    </div>
    @include("Admins.layout.parts.scripts")
    @stack("scripts")
  </body>
</html>