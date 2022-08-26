<div class="col-12 col-md-5 col-lg-4 tt-aside tt-aside__indent-large">
    <div class="tt-block-aside no-inner">
        <div class="tt-aside-content">
            <ul class="submenu-aside">
                @foreach($website->services as $item)
                    <li  class="@if(url()->current() == route('single.service',['id'=>$website->websiteUrl , 'service' =>  $item->id ]) ) active @endif"><a href="{{ route('single.service',['id'=>$website->websiteUrl , 'service' =>  $item->id ])  }}">{{ $item->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="tt-block-aside">
        <h3 class="tt-aside-title">Our Contacts</h3>
        <div class="tt-aside-content">
            <ul class="box-aside-info">
                <li>
                    <i class="icons-484169"></i>
                    {{ $website->bookingConfiguration->line }}, {{ $website->bookingConfiguration->city }}, {{ $website->bookingConfiguration->postCode }}
                </li>
                <li>
                    <i class="icons-59252"></i>
                    Mon-Fri 0{{ $website->bookingConfiguration->businessHours['monday']['startTime'] }}:00 AM - 0{{ $website->bookingConfiguration->businessHours['monday']['endTime'] -12 }}:00 PM<br>
                    Sat-Sun 0{{ $website->bookingConfiguration->businessHours['saturday']['startTime'] }}:00 AM -  0{{ $website->bookingConfiguration->businessHours['saturday']['endTime'] -12 }}:00 PM
                </li>
                <li>
                    <i class="icons-1004017"></i>
                    <a href="mailto:{{  $website->user->email }}">{{  $website->user->email }}</a>
                </li>
                <li>
                    <i class="icons-4839471"></i>
                    {{  $website->user->phone }}
                </li>
            </ul>
            <a href="{{ route('website.services', ['id'=>$website->websiteUrl]) }}" class="tt-btn btn__color01" data-toggle="modal" data-target="#modalMRequestQuote">
                <span class="mask">Schedule a Pickup</span>
                <div class="button">Schedule a Pickup</div>
            </a>
        </div>
    </div>
    <div class="tt-block-aside no-wrapper">
        <h3 class="tt-aside-title">Ask Your Question</h3>
        <div class="tt-aside-content">
            <form id="questionform" class="form-default" method="post" novalidate="novalidate" action="#">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your name">
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <input type="text" name="phonenumber" class="form-control" placeholder="Phone">
                </div>
                <div class="form-group">
                    <textarea name="textarea" class="form-control" rows="4" placeholder="Your question"></textarea>
                </div>
                <div class="tt-btn btn__color01 tt-btn__wide">
                    <span class="mask">Ask Question</span>
                    <button type="submit" class="button">Ask Question</button>
                </div>
            </form>
        </div>
    </div>
</div>