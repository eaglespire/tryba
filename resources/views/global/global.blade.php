@extends('global.layout.layout')
@section('content')
<div class="d-flex flex-row ">
    <section class="w-25  d-flex flex-column  align-content-center justify-items-center" style="display:block">
       <div class="w-100 p-2 d-flex flex flex-row align-items-center justify-center justify-content-center ">
         <span style="width:120px">
          <img src="{{ asset('images/Vector (6).png') }}"  style="width:100%; height:100%;"/>
         </span>
       </div>
        <div class="border border-dark border-top-0 border-right-0 border-left-0" style="width:60%; margin:auto; height:0px;"></div>
        <div class="w-100 d-flex flex flex-row p-2">
            <div class="w-25 d-flex justify-content-center" >
                <span class="" style="width:50px; height:50px;">
                    <img src="{{ asset('images/Frame 2399.png') }}" style="width:100%; heigth:100%;" />
                </span>
            </div>
            <div class="w-75  text-uppercase text-left d-flex align-items-center">
              Dashboard
            </div>
        </div>
        <div class="w-100 d-flex p-3 text-left font-weight-normal" style="font-size:20px;">
           Business
        </div>
        <section class="w-100 flex flex-row align-content-center ">
           <span class="w-25">
               <img src="{{ asset('images/Frame 2399 (1).png') }}" />
           </span>
           <span class="w-75 font-weight-bold">
            Website
           </span>
        </section>

        <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (2).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                Storefront
            </span>
         </section>


         <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (3).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                Business Tools
            </span>
         </section>

         <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (4).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                Transactions
            </span>
         </section>

         <div class="w-100 d-flex p-3 text-left font-weight-normal" style="font-size:20px;">
            Account
         </div>

         <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (5).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                Support
            </span>
         </section>

         <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (6).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                Developers
            </span>
         </section>

         <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (9).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                Global Settings
            </span>
         </section>

         <section class="w-100 flex flex-row align-content-center ">
            <span class="w-25">
                <img src="{{ asset('images/Frame 2399 (8).png') }}" />
            </span>
            <span class="w-75 font-weight-bold">
                logout
            </span>
         </section>

    </section>
    <section class="w-75  d-flex flex-row">
        <div class="w-25 ">
            <article class="w-100 p-3 d-flex flex flex-row bg-primary text-white">
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
                    <div class="text-left w-100
                    font-weight-bold">Billinggh</div>
                    <div class="text-left w-100 font-weight-light" style="font-size:13px;">Gravida gravida nisi, magna blandit</div>
                </span>
            </article>


            <article class="w-100 p-3 d-flex flex flex-row  justify-content-center">
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
        <div class="w-75 border border-light d-flex flex-column p-2">
        <section class="w-100 p-2 d-flex flex-column">
            <div class="w-25 float-left font-weight-bold" style="font-size: 30px;">
                Global Settings
            </div>
            <div class="w-25 float-left font-weight-light" style="font-size: 20px;">
                Profile
            </div>
        </section>
        <section class="w-100 d-flex flex-row ">
         <div class="flex align-items-center" style="width:30%; ">
             <article class="" style="width:40px; position:relative;">
                <img src="{{ asset('images/Frame 2721 (1).png') }}"  style="width:"/>
                <span class="" style="position:absolute; top:0%; left:100px; width:20px;">
                    <img src="{{ asset('images/Frame 2722.png') }}" />
                 </span>
             </article>
         </div>
         <section class="d-flex flex-column " style="width:70%;">
            <div class="w-100 d-flex flex-row">
                <span class="float-left font-weight-bold" style="width:10%; "> </span>
                <span class="float-left font-weight-bold" style="width:90%;">Image Upload guideline</span>
                </div>
                <section class="w-100 p-4 text-left">
                    For additional security and to help protect against fraud,
                    we'Il check the details you provide against the payee's account details,
                    including the name on their account. Although this does not prevent all types of fraud,
                    this will help give you reassurancethat you are paying the correct person.
                </section>
         </section>
        </section>

        <article class=" d-flex flex-column" style="width:80%;">
            <section  class="d-flex justify-content-between  align-items-center   w-100" style="margin:2px;">
                <div class="d-flex flex-column  " style="width:48%; ">
                 <span class="w-100 d-flex flex-row align-items-center ">
                  <h2 class="text-capitalize" style="font-size:15px;">first name</h2><h2 class="text-danger">*</h2>
                 </span>
                   <input type="text" class="p-3" placeholder="First Name" style="width:100%; background: rgba(0, 175, 239, 0.258); border-radius:5px 5px; border:none; outline:none;" />
                </div>

                <div class="d-flex flex-column  " style="width:48%;">
                    <span class="w-100 d-flex flex-row align-items-center ">
                        <h2 class="text-capitalize" style="font-size:15px;">last name</h2><h2 class="text-danger">*</h2>
                    </span>
                      <input type="text" class="p-3" placeholder="Last Name" style="width:100%;  background: rgba(0, 175, 239, 0.258); border-radius:5px 5px; border:none; outline:none;" />
                   </div>
            </section>

            <div class="d-flex flex-column  " style="width:100%;">
                <span class="w-100 d-flex flex-row align-items-center ">
                    <h2 class="text-capitalize" style="font-size:15px;">Contact Phone</h2><h2 class="text-danger">*</h2>
                </span>
                <div class="w-100 d-flex flex-row ">
                 <span class="d-flex align-items-center justify-content-md-center rounded-left" style="width:5%; font-weight-bold; background: rgba(0, 175, 239, 0.258); ">
                      44
                 </span>
                 <span class="" style="width:95%;">
                    <input type="text" class="p-3 rounded-right" placeholder="Contact Phone" style="width:100%;  background: rgba(0, 175, 239, 0.258); border:none; outline:none;" />
                 </span>
                </div>
               </div>


               <div class="d-flex flex-column  " style="width:100%;">
                <span class="w-100 d-flex flex-row align-items-center ">
                    <h2 class="text-capitalize" style="font-size:15px;">Email Address</h2><h2 class="text-danger">*</h2>
                </span>
                <div class="w-100 d-flex flex-row ">
                    <input type="text" class="p-3 rounded-right" placeholder="Email Address" style="width:100%;  background: rgba(0, 175, 239, 0.258); border:none; outline:none;" />
                </div>
               </div>


               <div class="d-flex flex-column  " style="width:100%;">
                <span class="w-100 d-flex flex-row align-items-center ">
                    <h2 class="text-capitalize" style="font-size:15px;">Industry</h2><h2 class="text-danger">*</h2>
                </span>
                <div class="w-100 d-flex flex-row ">
                    <input type="text" class="p-3 rounded-right" placeholder="MCC" style="width:100%;  background: rgba(0, 175, 239, 0.258); border:none; outline:none;" />
                </div>
               </div>

        </article>

        </div>
    </section>
</div>
@endsection
