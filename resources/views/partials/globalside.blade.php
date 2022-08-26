<div class="w-25 bg-white backgr">
    @if ($title == 'Profile')
    <article class="w-100 p-3 d-flex flex flex-row bg-primary text-white profile" >
            <div class=" d-flex flex-col align-items-center justify-content-center rounded-circle firstimg" style="width:60px; height:60px;">
                <img src="{{ asset('images/icon.png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class="w-75 d-flex flex-column align-items-center">
            <div class="text-left w-100">Profile</div>
            <div class="text-left w-100" style="font-size:13px;">Set up and manage your business</div>
        </span>
    </article>
    @else
    <article class="w-100 p-3 d-flex flex flex-row align-items-center bg-white " >
        <span class="w-25 ">
            <div class=" d-flex flex-col align-items-center justify-content-center rounded-circle" style="width:60px; height:60px;">
                <img src="{{ asset('images/icon.png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class="w-75 d-flex flex-column align-items-center">
            <div class="text-left w-100">Profile</div>
            <div class="text-left w-100" style="font-size:13px;">Set up and manage your business</div>
        </span>
    </article>

    @endif


    @if ($title == 'preference')
    <article class="w-100 p-3 d-flex flex flex-row bg-primary text-white justify-content-center">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (1).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold">Preferences</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>
    @else
    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (1).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold">Preferences</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>

    @endif


   @if($title == 'Security')
   <article class="w-100 p-3 d-flex flex flex-row  bg-primary text-white justify-content-center">
    <span  style="width:25%;">
        <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
            <img src="{{ asset('images/icon (2).png') }}" alt="img" style="width: 100%; height:100%;" />
        </div>

    </span>
    <span class=" d-flex flex-column align-items-center" style="width:75%;">
        <div class="text-left w-100 font-weight-bold">Security</div>
        <div class="text-left w-100 font-weight-light" style="font-size:13px;">Manage notifications</div>
    </span>
</article>
   @else
   <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
    <span  style="width:25%;">
        <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
            <img src="{{ asset('images/icon (2).png') }}" alt="img" style="width: 100%; height:100%;" />
        </div>

    </span>
    <span class=" d-flex flex-column align-items-center" style="width:75%;">
        <div class="text-left w-100 font-weight-bold">Security</div>
        <div class="text-left w-100 font-weight-light" style="font-size:13px;">Manage notifications</div>
    </span>
</article>
   @endif
    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (3).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold">Social Accounts</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>

    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (4).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold">Billing</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>

    @if ($title == 'API Keys & Webhooks')
    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center bg-primary text-white">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (5).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold " style="font-size:14px;">Bill API Keys & Webhooksing</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>
    @else
    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center ">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (5).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold " style="font-size:14px;">Bill API Keys & Webhooksing</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>

    @endif



    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (6).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold " style="font-size:14px;">Connections</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>


    <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
        <span  style="width:25%;">
            <div class=" d-flex flex-col align-items-center justify-content-center float-right" style="width:50px; height:50px;">
                <img src="{{ asset('images/icon (7).png') }}" alt="img" style="width: 100%; height:100%;" />
            </div>

        </span>
        <span class=" d-flex flex-column align-items-center" style="width:75%;">
            <div class="text-left w-100 font-weight-bold " style="font-size:14px;">Permissions</div>
            <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
        </span>
    </article>

    </div>
