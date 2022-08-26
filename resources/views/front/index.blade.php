@extends('layout')
@section('css')

@stop
@section('content')
<section class="mt-n11 pt-12 pt-md-14 bg-black bg-pattern-2">
  <div class="container-fluid">
    <div class="row justify-content-centers">
      <div class="col-12 col-md-7 col-lg-6 order-md-1 mb-6">
        <h2 class="display-1 fw-bold text-white" data-aos="fade-up" data-aos-delay="50">
          {{__('Business management and eCommerce simplified')}}
        </h2>
        <p class="lead text-gray-500 mb-6 mx-autos" data-aos="fade-up" data-aos-delay="100" style="max-width: 500px;">
          {{__('A safe and secure platform to launch your storefront, create invoices, and accept online payments with no chargebacks.')}}
        </p>
        <p class="mb-7 mb-md-9" data-aos="fade-up" data-aos-delay="150">
          <a class="btn btn-primary shadow lift mb-3" href="{{route('register')}}">
            Create a free account <i class="fe fe-arrow-right ms-3"></i>
          </a>          
          <a class="btn btn-secondary shadow lift mb-3" href="{{route('contact')}}">
            Book a demo
          </a>
        </p>
        <h6 class="text-uppercase text-warning mb-5">{{__('Download our Apps')}}</h6>
        <a href="https://apps.apple.com/gb/app/tryba/id1590314942" class="text-reset d-inline-block me-1" title="Coming soon">
          <img src="{{asset('asset/images/button-app.png')}}" class="img-fluid" alt="..." style="max-width: 155px;">
        </a>

        <a href="https://play.google.com/store/apps/details?id=com.tryba.io" target="_blank" class="text-reset d-inline-block" title="Android">
          <img src="{{asset('asset/images/button-play.png')}}" class="img-fluid" alt="..." style="max-width: 155px;">
        </a>
      </div>      
      <div class="col-12 col-md-5 col-lg-6 order-md-2">
        <img src="{{asset('asset/images/'.$ui->s3_image)}}" class="img-fluid mb-6 mb-md-0 d-none d-sm-block" alt="..." data-aos="fade-up" data-aos-delay="100">
      </div>
    </div>
  </div>
</section>
<section class="bg-gradient-dark-black py-8 py-md-11">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-7 text-center">
        <h2 class="display-3 fw-bold text-white">{{__('Tryba.io is helping small businesses launch for free.')}}</h2>
        <p class="lead text-muted mb-9">{{__('Tryba.io is a business + eCommerce platform built to help new and existing businesses launch fully functional Storefronts instantly, create/mange invoices at no cost and take End-to-End Online payments with no obligation or fraudulent chargebacks. ')}}</p>
      </div>
    </div>
    <div class="row mt-n7">
      <div class="col-12 col-sm-6 col-lg-4 mt-7">
        <div class="card h-100 bg-dark rounded-3">
          <div class="card-body p-5">
            <h3 class="fw-bold text-white">
              {{__('Create an instant account')}}
            </h3>
            <p class="text-muted mb-0">
              {{__('Creating an account on tryba.io takes only one minute.')}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 mt-7">
        <div class="card h-100 bg-dark rounded-3">
          <div class="card-body p-5">
            <h3 class="fw-bold text-white">
              {{__('Setup your payment pages')}}
            </h3>
            <p class="text-muted mb-0">
              {{__('Choose from variety of payment pages like Storefront, Invoice etc and setup.')}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 mt-7">
        <div class="card h-100 bg-dark rounded-3">
          <div class="card-body p-5">
            <h3 class="fw-bold text-white">
              {{__('Marketplace')}}
            </h3>
            <p class="text-muted mb-0">
              {{__('Reach and sell to more customers by displaying your products on tryba\'s marketplace.')}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 mt-7">
        <div class="card h-100 bg-dark rounded-3">
          <div class="card-body p-5">
            <h3 class="fw-bold text-white">
              {{__('Send payment links')}}
            </h3>
            <p class="text-muted mb-0">
              {{__("After setting up payment pages, it’s time to send it out. We included QR, SMS etc.")}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 mt-7">
        <div class="card h-100 bg-dark rounded-3">
          <div class="card-body p-5">
            <h3 class="fw-bold text-white">
              {{__('Receive Instant payments')}}
            </h3>
            <p class="text-muted mb-0">
              {{__('Let your customers, friends and family pay you instantly within the U.K & Europe.')}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 mt-7">
        <div class="card h-100 bg-dark rounded-3">
          <div class="card-body p-5">
            <h3 class="fw-bold text-white">
              {{__('Instant Payout')}}
            </h3>
            <p class="text-muted mb-0">
              {{__('We use End-to-End Open banking technology to ensure funds are settled immediately.')}}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pt-8 pt-md-11 bg-black">
  <div class="container">
    <div class="row justify-content-center pb-8">
      <div class="col-12 col-md-10 col-lg-8 text-center">
        <h6 class="text-uppercase text-warning">{{__('Our features')}}</h6>
        <h1 class="fw-bold text-white">{{__('The amazing features of Tryba.io')}}</h1>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-12 col-md-6 col-lg-7">
        <div class="mb-8 mb-md-0">
          <img src="{{asset('asset/images/smile.jpg')}}" alt="..." class="screenshot img-fluid mw-md-110 float-end me-md-6 mb-6 mb-md-0">
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-5">
        <p class="text-muted mb-6">
          <span class="text-white fw-bold">{{__('Storefront.')}}</span> {{__('Selling without a website? Just create your online store on tryba.io and start selling, completely free.')}}
        </p>
        <p class="text-muted mb-6">
          <span class="text-white fw-bold">{{__('Invoicing.')}}</span> {{__('Create intelligent invoicing that "chases" your clients and customers to make payments.')}}
        </p>
        <p class="text-muted mb-7 ">
          <span class="text-white fw-bold">{{__('Gigpot.')}}</span> {{__('Get your friends & families to contribute to your gig no matter where they are.')}}
        </p>
        <p class="text-muted mb-7 ">
          <span class="text-white fw-bold">{{__('Merchant.')}}</span> {{__('Have a website and wish to use tryba\'s checkout? We have varieties of APIs and plugins that can help.')}}
        </p>
      </div>
    </div>
  </div>
</section>
<section class="bg-black py-8 py-md-13">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8 text-center">

        <!-- Preheading -->
        <h6 class="text-uppercase text-warning">{{__('Our PURPOSE')}}</h6>

        <!-- Heading -->
        <h1 class="fw-bold text-white">
          {{__('Tryba\'s promise to Small businesses.')}}
        </h1>

        <!-- Text -->
        <p class="fs-lg text-muted mb-9">
          {{__('Storefront launch, Invoicing, bank level security, instant payment settlement and transactions, all sorted for you.')}}
        </p>

      </div>
    </div> <!-- / .row -->
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 text-center">
        <div class="icon icon-lg mb-4">
          <img src="{{asset('asset/images/fingerprint.png')}}" style="max-height:auto; width:20%;">
        </div>
        <h3 class="fw-bold text-white">{{__('Instant payment')}}</h3>
        <p class="text-muted mb-8">
          {{__('Enabled by SafeConnect Ltd for seamless and instant bank to bank payment with no chargebacks')}}
        </p>
      </div>
      <div class="col-12 col-md-6 col-lg-4 text-center">
        <div class="icon icon-lg mb-4">
          <img src="{{asset('asset/images/shield.png')}}" style="max-height:auto; width:20%;">
        </div>
        <h3 class="fw-bold text-white">{{__('Secure platform')}}</h3>
        <p class="text-muted mb-8">
          {{__('Powered by the latest security for secure transactions as referenced in our')}} <a class="text-white" href="{{route('terms')}}">{{__('terms & conditions')}}</a>
        </p>
      </div>
      <div class="col-12 col-md-6 col-lg-4 text-center">
        <div class="icon icon-lg mb-4">
          <img src="{{asset('asset/images/free.png')}}" style="max-height:auto; width:20%;">
        </div>
        <h3 class="fw-bold text-white">{{__('Free forever')}}</h3>
        <p class="text-muted mb-8">
          {{__('Tryba.io was built to eliminate excessive transaction charges and will remain free forever')}}
        </p>
      </div>
    </div> <!-- / .row -->
    <div class="text-center">
      <a href="{{route('register')}}" class="btn btn-primary lift">{{__('Create an account')}} <i class="fe fe-arrow-right ms-2"></i></a>
    </div>
  </div> <!-- / .container -->
</section>
<section class="py-14 py-lg-16 jarallax" data-jarallax data-speed=".8" style="background-image: url({{asset('/')}}asset/images/castro.png);">

  <!-- Shape -->
  <div class="shape shape-top shape-fluid-x text-black">
    <svg viewBox="0 0 2880 250" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 0h2880v125h-720L720 250H0V0z" fill="currentColor" />
    </svg>
  </div>

  <!-- Shape -->
  <div class="shape shape-bottom shape-fluid-x text-black">
    <svg viewBox="0 0 2880 250" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M720 125L2160 0h720v250H0V125h720z" fill="currentColor" />
    </svg>
  </div>

</section>
<section class="py-10 py-md-14 bg-black">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8 text-center">

        <!-- Pretitle -->
        <h6 class="text-uppercase text-warning mb-6">
          {{__('BUILDING A BETTER FUTURE FOR FREELANCERS')}}
        </h6>

        <!-- Heading -->
        <h1 class="display-1 fw-bold text-white">
          {{__('Goodbye to transaction fees.')}}
        </h1>

        <!-- Text -->
        <p class="fs-lg text-gray-500 mb-6 mb-md-8">
          {{__('Whatever your payment needs are, Tryba.io will support your everyday business needs for free.')}}
        </p>
        <!-- TrustBox widget - Review Collector -->
        <div class="trustpilot-widget" data-locale="en-GB" data-template-id="56278e9abfbbba0bdcd568bc" data-businessunit-id="6130a568409791001c697fa6" data-style-height="52px" data-style-width="100%">
          <a href="https://uk.trustpilot.com/review/tryba.io" target="_blank" rel="noopener">Trustpilot</a>
        </div>
        <!-- End TrustBox widget -->
        <!-- Button -->
      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</section>
<!-- TrustBox widget - Review Collector -->
<!-- End TrustBox widget -->
<section class="pt-6 pt-md-8 bg-black">
  <div class="container pb-6 pb-md-8">
    <h6 class="text-uppercase text-warning text-center mb-3">{{__('We are Featured on')}}</h6>
    <div class="row align-items-center text-center">

      <div class="col-lg-4 col-4">

        <a target="_blank" href="https://www.wtnzfox43.com/story/44729846/tryba-uk-limited-launches-trybaio-a-revolutionary-payment-platform-to-the gig-economy" class="text-reset d-inline-block mr-2" title="Coming soon">
          <img src="{{asset('asset/images/fox_news.png')}}" class="img-fluid" alt="..." style="max-width: 80px;">
        </a>
      </div>
      <div class="col-lg-4 col-4">
        <a target="_blank" href="https://www.wrde.com/story/44729846/tryba-uk-limited-launches-trybaio-a-revolutionary-payment-platform-to-the gig-economy" class="text-reset d-inline-block mr-2" title="Coming soon">
          <img src="{{asset('asset/images/cbs_news1.png')}}" class="img-fluid" alt="..." style="max-width: 80px;">
        </a>
      </div>
      <div class="col-lg-4 col-4">
        <a target="_blank" href="https://www.wboc.com/story/44729846/tryba-uk-limited-launches-trybaio-a-revolutionary-payment-platform-to-the gig-economy" class="text-reset d-inline-block mr-2" title="Coming soon">
          <img src="{{asset('asset/images/cbs.png')}}" class="img-fluid" alt="..." style="max-width: 80px;">
        </a>
      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</section>
@stop