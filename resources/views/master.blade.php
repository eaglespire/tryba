<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <base href="{{url('/')}}" />
  <title>{{ $title }} | {{$set->site_name}}</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
  <meta name="description" content="{{$set->site_desc}}" />
  <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
  <link rel="stylesheet" href="{{config('sweetalert.animatecss')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/quill/dist/quill.core.css')}}">
  <link rel="stylesheet" href="{{asset('asset/dashboard/css/argon.css?v=1.1.0')}}" type="text/css">
  <link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('asset/fonts/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{asset('asset/css/toast.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('asset/dashboard/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  @yield('css')

</head>
<!-- header begin-->

<body>
  <div class=""></div>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-dark" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{url('/')}}">
          <img src="{{asset('asset/'.$logo->dark)}}" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav mb-3">
            @if($admin->profile == 1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.dashboard')==url()->current()) active @endif" href="{{route('admin.dashboard')}}">
                <i class="fal fa-user"></i>
                <span class="nav-link-text">{{__('Customers')}}</span>
              </a>
            </li>
            @endif
            @if($admin->id == 1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.staffs')==url()->current()) active @endif" href="{{route('admin.staffs')}}">
                <i class="fal fa-user"></i>
                <span class="nav-link-text">{{__('Staffs')}}</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link @if(route('user.compliance')==url()->current()) active @endif" href="{{route('user.compliance')}}">
                <i class="fal fa-check-double"></i>
                <span class="nav-link-text">{{__('Compliance')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.blocked.user')==url()->current()) active @endif" href="{{route('admin.blocked.user')}}">
                <i class="fal fa-user"></i>
                <span class="nav-link-text">{{__('Blocked Accounts')}}</span>
              </a>
            </li>
            @if($admin->promo == 1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.promo')==url()->current()) active @endif" href="{{route('admin.promo')}}">
                <i class="fal fa-envelope"></i>
                <span class="nav-link-text">{{__('Promotional Emails')}}</span>
              </a>
            </li>
            @endif
            @if($admin->support == 1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.ticket')==url()->current()) active @endif" href="{{route('admin.ticket')}}">
                <i class="fal fa-ticket"></i>
                <span class="nav-link-text">{{__('Support ticket')}}
                  @if(count($pticket)>0)
                  <span class="badge badge-sm badge-circle badge-floating badge-danger border-white">{{count($pticket)}}</span>
                  @endif
                </span>
              </a>
            </li>
            @endif
            @if($admin->message==1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.message')==url()->current()) active @endif" href="{{route('admin.message')}}">
                <i class="fal fa-sticky-note"></i>
                <span class="nav-link-text">{{__('Messages')}}</span>
                @if($unread>0)
                <span class="badge badge-sm badge-circle badge-floating badge-danger border-white">
                  {{$unread}}
                </span>
                @endif
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link @if(route('admin.website.themes')==url()->current()) active @endif" href="{{route('admin.website.themes')}}">
                <i class="fal fa-browser"></i>
                <span class="nav-link-text">{{__('Website Themes')}}</span>
              </a>
            </li>
            @if($admin->store==1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.product')==url()->current()) active @endif" href="{{route('admin.product')}}">
                <i class="fal fa-shopping-bag"></i>
                <span class="nav-link-text">{{__('Products')}}</span>
              </a>
            </li>
            @endif
            @if($admin->single_charge==1 || $admin->donation==1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.dplinks')==url()->current() || route('admin.sclinks')==url()->current()) active @endif" href="#navbar-examples3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples3">
                <!--For modern browsers-->
                <i class="fal fa-tags"></i>
                <span class="nav-link-text">{{__('Payment Links')}}</span>
              </a>
              <div class="collapse @if(route('admin.dplinks')==url()->current() || route('admin.sclinks')==url()->current()) show @endif" id="navbar-examples3">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item @if(route('user.dplinks')==url()->current()) active @endif text-default">
                    <a href="{{route('admin.dplinks')}}" class="nav-link">{{__('Multiple Pot')}}</a>
                  </li>
                  <li class="nav-item @if(route('user.sclinks')==url()->current()) active @endif text-default">
                    <a href="{{route('admin.sclinks')}}" class="nav-link">{{__('Single Pot')}}</a>
                  </li>
                </ul>
              </div>
            </li>
            @endif
            @if($admin->invoice==1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.invoice')==url()->current()) active @endif" href="{{route('admin.invoice')}}">
                <i class="fal fa-envelope"></i>
                <span class="nav-link-text">{{__('Invoice')}}</span>
              </a>
            </li>
            @endif
            @if($admin->merchant==1)
            <li class="nav-item">
              <a class="nav-link @if(route('merchant.log')==url()->current()) active @endif" href="{{route('merchant.log')}}">
                <i class="fal fa-laptop"></i>
                <span class="nav-link-text">{{__('Website Integration')}}</span>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link @if(route('admin.transactions')==url()->current()) active @endif" href="{{route('admin.transactions')}}">
                <i class="fal fa-credit-card"></i>
                <span class="nav-link-text">{{__('Transactions')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.country')==url()->current()) active @endif" href="{{route('admin.country')}}">
                <i class="fal fa-globe"></i>
                <span class="nav-link-text">{{__('Country Settings')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('fc.index')==url()->current()) active @endif" href="{{route('fc.index')}}">
                <i class="fad fa-globe"></i>
                <span class="nav-link-text">{{__('Product Category')}}</span>
              </a>
            </li>            
            <li class="nav-item">
              <a class="nav-link @if(route('mcc.index')==url()->current()) active @endif" href="{{route('mcc.index')}}">
                <i class="fad fa-globe"></i>
                <span class="nav-link-text">{{__('MCC')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.plans')==url()->current()) active @endif" href="{{route('admin.plans')}}">
                <i class="fad fa-credit-card"></i>
                <span class="nav-link-text">{{__('Subscription plans')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.email.pricing')==url()->current()) active @endif" href="{{route('admin.email.pricing')}}">
                <i class="fad fa-credit-card"></i>
                <span class="nav-link-text">{{__('Email & SMS pricing')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.waiting')==url()->current()) active @endif" href="{{route('admin.waiting')}}">
                <i class="fal fa-user"></i>
                <span class="nav-link-text">{{__('Waiting list')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('domain.index')==url()->current()) active @endif" href="{{route('domain.index')}}">
                <i class="fad fa-globe"></i>
                <span class="nav-link-text">{{__('Custom Domain')}}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.getBugs')==url()->current()) active @endif" href="{{route('admin.getBugs')}}">
                <i class="fad fa-bug"></i>
                <span class="nav-link-text">{{__('Bug Report')}}</span>
              </a>
            </li>
          </ul>
          <h6 class="navbar-heading p-0 text-muted">{{__('More')}}</h6>
          <ul class="navbar-nav mb-3">
            @if($admin->blog==1)
            <li class="nav-item">
              <a class="nav-link @if(route('admin.blog')==url()->current() || route('admin.cat')==url()->current()) show @endif" href="#brcard" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fal fa-newspaper"></i>
                <span class="nav-link-text">{{__('Blog')}}</span>
              </a>
              <div class="collapse @if(route('admin.blog')==url()->current() || route('admin.cat')==url()->current()) show @endif" id="brcard">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item @if(route('admin.blog')==url()->current()) active @endif"><a href="{{route('admin.blog')}}" class="nav-link">{{__('Articles')}}</a></li>
                  <li class="nav-item @if(route('admin.cat')==url()->current()) active @endif"><a href="{{route('admin.cat')}}" class="nav-link">{{__('Category')}}</a></li>
                </ul>
              </div>
            </li>
            @endif
            @if($admin->id==1)
            <li class="nav-item">
              <a class="nav-link  @if(route('homepage')==url()->current() || route('admin.service')==url()->current() || route('admin.brand')==url()->current() || route('admin.logo')==url()->current() || route('admin.review')==url()->current() || route('admin.page')==url()->current() || route('admin.faq')==url()->current() || route('admin.terms')==url()->current() || route('privacy-policy')==url()->current() || route('about-us')==url()->current() || route('social-links')==url()->current()) active @endif" href="#xx" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                <i class="fal fa-desktop"></i>
                <span class="nav-link-text">{{__('Website design')}}</span>
              </a>
              <div class="collapse @if(route('homepage')==url()->current() || route('admin.service')==url()->current() || route('admin.brand')==url()->current() || route('admin.logo')==url()->current() || route('admin.review')==url()->current() || route('admin.page')==url()->current() || route('admin.faq')==url()->current() || route('admin.terms')==url()->current() || route('privacy-policy')==url()->current() || route('about-us')==url()->current() || route('social-links')==url()->current()) show @endif " id="xx">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item @if(route('homepage')==url()->current()) active @endif"><a href="{{route('homepage')}}" class="nav-link">{{__('Homepage')}}</a></li>
                  <li class="nav-item @if(route('admin.brand')==url()->current()) active @endif"><a href="{{route('admin.brand')}}" class="nav-link">{{__('Brands')}}</a></li>
                  <li class="nav-item @if(route('admin.logo')==url()->current()) active @endif"><a href="{{route('admin.logo')}}" class="nav-link">{{__('Logo & Favicon')}}</a></li>
                  <li class="nav-item @if(route('admin.review')==url()->current()) active @endif"><a href="{{route('admin.review')}}" class="nav-link">{{__('Platform Review')}}</a></li>
                  <li class="nav-item @if(route('admin.service')==url()->current()) active @endif"><a href="{{route('admin.service')}}" class="nav-link">Services</a></li>
                  <li class="nav-item @if(route('admin.page')==url()->current()) active @endif"><a href="{{route('admin.page')}}" class="nav-link">{{__('Webpages')}}</a></li>
                  <li class="nav-item @if(route('admin.faq')==url()->current()) active @endif"><a href="{{route('admin.faq')}}" class="nav-link">{{__('FAQs')}}</a></li>
                  <li class="nav-item @if(route('admin.terms')==url()->current()) active @endif"><a href="{{route('admin.terms')}}" class="nav-link">{{__('Terms & Condition')}}</a></li>
                  <li class="nav-item @if(route('privacy-policy')==url()->current()) active @endif"><a href="{{route('privacy-policy')}}" class="nav-link">{{__('Privacy policy')}}</a></li>
                  <li class="nav-item @if(route('about-us')==url()->current()) active @endif"><a href="{{route('about-us')}}" class="nav-link">{{__('About us')}}</a></li>
                  <li class="nav-item @if(route('social-links')==url()->current()) active @endif"><a href="{{route('social-links')}}" class="nav-link">{{__('Social Links')}}</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(route('admin.setting')==url()->current()) active @endif" href="{{route('admin.setting')}}">
                <i class="fal fa-cogs"></i>
                <span class="nav-link-text">{{__('Settings')}}</span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->

          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center ml-md-auto">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-light" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center ml-auto ml-md-0">
            <li class="nav-item">
              <a class="nav-link pr-0" href="javascript:void" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="{{asset('asset/profile/person.png')}}">
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm text-default">{{Auth::guard('admin')->user()->username}}</span>
                  </div>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.logout')}}" class="nav-link pr-0">
                <i class="fal fa-sign-out text-dark"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="header pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center">
            <div class="col-lg-6 col-7">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    @yield('content')
  </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{asset('asset/dashboard/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/chart.js/dist/Chart.extension.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/jvectormap-next/jquery-jvectormap.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/js/vendor/jvectormap/jquery-jvectormap-world-mill.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/clipboard/dist/clipboard.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/select2/dist/js/select2.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/nouislider/distribute/nouislider.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/quill/dist/quill.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/dropzone/dist/min/dropzone.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/jszip.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/pdfmake.min.js')}}"></script>
  <script src="{{asset('asset/dashboard/vendor/datatables.net-buttons/js/vfs_fonts.js')}}"></script>
  <script src="{{asset('asset/dashboard/js/argon.js?v=1.1.0')}}"></script>
  <script src="{{asset('asset/dashboard/js/demo.min.js')}}"></script>
  <script src="{{asset('asset/js/toast.js')}}"></script>
  <script src="{{asset('asset/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('asset/tinymce/init-tinymce.js')}}"></script>
  @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>


@yield('script')
<script type="text/javascript">
  "use strict";

  function exchange() {
    var percent = $("#percent").val();
    var duration = $("#duration").val();
    var period = $("#period").find(":selected").text();
    var myarr1 = period.split("-");
    var dar1 = myarr1[1].split("<");
    var compound = parseFloat(percent) * parseFloat(duration) * parseInt(dar1);
    var interest = compound - 100;
    $("#compound").val(compound);
    $("#interest").val(interest);
  }
  $("#percent").change(exchange);
  exchange();
  $("#duration").change(exchange);
  exchange();
  $("#period").change(exchange);
  exchange();
</script>
</html>