<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
   <link rel="stylesheet" href="{{ asset('css/drag.css') }}" type="text/css" >

    <title>Document</title>
</head>
<body>
 <div class="w-100 d-flex flex-column" >
  <article class="w-100" id="back">
   <div class="w-100 p-3" style="display:flex; align-items:center;  justify-content: center; ">
       <span style="width:10%;">
           <img src="{{ asset('images/Vector (6).png') }}"  style="width:100%; height:40px;"/>
       </span>
         <article class="" style="width:60%;">
            <ul class="d-flex flex-row align-content-center justify-content-between" style="width:60%; margin:auto;">
                <li style="list-style:none;">Features</li>
                <li style="list-style:none;">Pricing</li>
                <li style="list-style:none;">Resources</li>
                <li style="list-style:none;">Support</li>
            </ul>
         </article>
         <span class="" style="width:20%; display:flex; align-items:center;  " >
           <ul class="" style="width:60%; display:flex;  align-items:center; justify-content:space-between; ">
               <li style="list-style:none;  display:flex;  align-items:center;">
                <button class="border-primary p-2 rounded text-primary " style="border:none; outline:none;   float: left;">Sign up</button>
               </li>
               <li style="list-style:none;  display:flex;  align-items:center;">
                <button class="p-2 text-white rounded" style="background-color:#00AFEF; border:none; outline:none;   float:right;" >Sign in</button>
               </li>
           </ul>
         </span>
   </div>
   <section class="w-100 d-flex flex-row align-content-center justify-content-center p-5"  style="">
    <div class="p-3 d-flex flex-column align-content-center justify-content-center" style="width:70%;   text-align: center;">
       <div class="d-flex flex-row" style="">
           <h2 class="" style="color:black; font-size:80px;">Your</h2><h2 style="color:#00AFEF; font-size:80px;">Banking,</h2>
       </div>
       <div class="d-flex flex-row" style="">
      <h2 style="color:#00AFEF; font-size:80px;">Payments</h2>  <h2 class="" style="color:black; font-size:80px;">and</h2><h2 style="color:#00AFEF; font-size:80px;">Business</h2>
    </div>
    <div class="d-flex flex-row" style="">
      <h2 class="" style="color:black; font-size:80px;">needs In one place</h2>
      </div>
      <div class="" style="width:40%;   text-align: left;  font-family: 'Poppins'; ">
        Intelligent Banking platform with built-in Business,
         Payments and Reporting for any business size.
      </div>
      <article class="" style="width:30%; margin-top:10px;">
          <button class="w-75 p-2" style="border:none; background-color:#00AFEF; color:white; border-radius:6px 6px; outline:none;">
            Open Account
          </button>
      </article>
    </div>

    <div class="d-flex flex-row align-content-center" style="width:30%; p-5 ">
      <img src="{{ asset('images/Rectangle.png') }}"  width="100%" height="100%"/>
    </div>
   </section>


  </article>


    <section class="w-100" style="background: #E5E5E5;">
       <article class="d-flex flex-column align-items-center justify-items-center" style="width:50%; margin:auto;">
        <h2 style="font-size:15px;">Who is Tryba for?</h2>
        <h2 style="font-size:22px; ">Business solutions designed with much love for the gig economy.</h2>
       </article>

       <article class="w-75 d-flex flex-row  " style="margin:auto; gap:80px;">

        <section class="rounded d-flex flex-column align-content-center" style="width:25%; background-color:#FFE770;">
            <article class="w-100" style="display:flex; flex-direction:column; margin:10px;">
             <h2 class="" style="color:#5C8993; font-size:18px; margin:auto;">Online Seller</h2>
             <section class="text-center" style="width:90%; font-size:12px;">
                Tryba’s business accounts and
                cards are designed to give you flexibility,
                allowing you to focus on your business.
             </section>
            </article>
            <article class="" style="width:90%;  margin:auto;">
             <img src="{{ asset('images/dog walking with grocery bag.png') }}" style="width:100%; heigth:100%;"/>
            </article>
        </section>

        <section class="rounded d-flex flex-column align-content-center" style="width:25%; background-color:#3F625E;">
            <article class="w-100" style="display:flex; flex-direction:column; margin:10px;">
             <h2 class="" style="color:#5C8993; font-size:18px; margin:auto;">Freelancer</h2>
             <section class="text-center" style="width:90%; font-size:12px;">
                Tryba’s business accounts and cards are
                designed to give you flexibility,
                allowing you to focus on your business.
             </section>
            </article>
            <article class="" style="width:90%;  margin:auto;">
             <img src="{{ asset('images/Man chatting remotely with woman colleague.png') }}" style="width:100%; heigth:100%;"/>
            </article>
        </section>


        <section class="rounded d-flex flex-column align-content-center" style="width:25%; background-color:#5D4D43;">
            <article class="w-100" style="display:flex; flex-direction:column; margin:10px;">
             <h2 class="" style="color:white; font-size:18px; margin:auto;">Corporation</h2>
             <section class="text-center" style="width:90%; font-size:12px; color:white;">
                Tryba’s business accounts and cards are designed to give you flexibility,
                 allowing you to focus on your business.
             </section>
            </article>
            <article class="d-flex flex-row align-content-center" style="width:90%; margin:auto;">
                <section class="" style="width:50%;">
                    <img src="{{ asset('images/old businesswoman in formalwear giving thumbs up.png') }}" style="width:100%; heigth:100%; object-fit: cover;"/>
                </section>
                <section class="" style="width:50%;">
                    <img src="{{ asset('images/old businessman in glasses standing giving thumbs up.png') }}" style="width:100%; heigth:100%; object-fit: cover;"/>
                </section>
            </article>
        </section>


       </article>

    </section>

    <section class="w-100 p-2" style="background: #E5E5E5;">
        <article class="d-flex flex-column align-items-center justify-items-center" style="width:50%; margin:auto; margin-top:20px;">
         <h2 style="font-size:15px;">Why Tryba?</h2>
         <h2 style="font-size:22px; ">Starting a business is quite hard, this is why we built tryba.</h2>
        </article>

          <article class="d-flex flex-row" style="width:60%; margin:auto; gap:80px; ">
            <section class="rounded d-flex flex-column align-content-center" style="width:30%; background-color:#FFE770;">
                <article class="w-100" style="display:flex; flex-direction:column; margin:10px;">
                 <h2 class="" style="color:black; font-size:18px; margin:auto;">Without Tryba</h2>
                 <section class="text-center" style="width:90%; font-size:12px; color:black;">
                      <ul class="w-100 text-left">
                          <li>Too expensive to buy multiple apps</li>
                          <li>Too many charge backs and fraud</li>
                          <li>Unpredictable time taken to receive payments.</li>
                    </ul>
                 </section>
                </article>
                <article class="d-flex flex-row align-content-center" style="width:60%; height:40%; margin:auto;">
                        <img src="{{ asset('images/Man confused by a lot of questions.png') }}" style="width:100%; heigth:100%; object-fit: cover;"/>
                </article>
            </section>


            <section class="rounded d-flex flex-column align-items-center justify-items-center" style="width:30%; background-color:#00AFEF;">
                <article class="w-100" style="display:flex; flex-direction:column; margin:10px;">
                 <h2 class="" style="color:white; font-size:18px; margin:auto;">With Tryba</h2>
                </article>

                <section class="text-center" style="width:90%; font-size:12px; color:black; margin-top:10px;">
                    <img src="{{ asset('images/checkmark.png') }}"  style="100%; height:100%; border-radius:50%;" />
                 </section>
                <article class="d-flex flex-column align-content-center" style="width:100%; height:40%; margin:auto;">
                  <h2 class="" style="font-size:15px; color:white; margin:auto;">One app for everything business</h2>
                  <section class="p-2 d-flex flex-column align-items-center justify-items-center" style="width:100%;  margin-top:8px;">
                         <button class="border border-white p-2 rounded">learn more</button>
                  </section>
                </article>
            </section>

          </article>

    </section>


 </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</html>
