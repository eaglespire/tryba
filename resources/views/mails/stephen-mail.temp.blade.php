<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/style.css')) }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
</head>
<body>
<div class="main">

    <article class="card">
       <span class="image">
           <img src="{{ asset('images/Vector.png') }}" alt="image" />
       </span>

      <div class="toptext">
          <span>
            Verify your
          </span>
          <span>
            email address
          </span>
      </div>
      <div class="line"></div>

      <section class="secondtext">
          <span>
            In order to start using your Tryba account, you need
          </span>
          <span>
            to confirm your email address
          </span>
      </section>

      <div class="btn">
          <button>
            Verify Email Address
          </button>
      </div>

      <section class="textlong">
        <span>
            If you did not sign up for thius account you can ignore
        </span>
        <span>
            this email and the account will be deleted.
        </span>
    </section>

    <section class="appleplay">
        <img src="{{ asset('images/image 1 (1).png') }}">
    </section>
    <div class="line"></div>


       <section class="socialmedia">
        {{--  <button>
           <img src="{{ asset('image/Vector (1).png') }}" />
        </button>
        <button>
            <img src="{{ asset('image/Vector (3).png') }}" />
         </button>

         <button>
            IG
         </button>  --}}

         <table>
            <tr>
                <td>
                    <button>
                        <img src="{{ asset('images/Vector (1).png') }}" />
                     </button>
                </td>
                <td>
                    <button>
                        <img src="{{ asset('images/Vector (3).png') }}" />
                     </button>
                </td>
                <td>
                    <button>
                        <img src="{{ asset('images/Vector (3).png') }}" />
                     </button>
                </td>
            </tr>
        </table>
       </section>

       <article class="comment">
        Your financial security is important to us. We will never include or ask for your card PIN or tryba
         password in our emails to you. If you’re ever suspicious of an email, please delete it immediately.
         If this email is received by anyone other than the addressee, please delete. Tryba Business Banking does
         not accept responsibility for changes made to this email after it was sent from us. Tryba U.K Limited
         designs and operates Tryba websites and app, which offers business current accounts and Cards with innovative
         built-in website and business management tools as a service. Tryba U.K Limited is a financial technology company
         registered in England and Wales with company number 13509269 and business mailing address at 126 Colmore Row,
         Birmingham, B3 3AP, United Kingdom. Tryba business current accounts and Visa cards are electronic money products
         issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the
         money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency.
          Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money
          (FRN 900573). Tryba U.K Limited also act as agent of SafeConnect Ltd for the provision of Open Banking and PISP
          technology. SafeConnect Ltd is authorised and regulated by the Financial Conduct Authority under the Payment Service
          Regulations 2017 (827001) for the provision of Account Information and Payment Initiation services.

        © 2022 Tryba. All rights reserved.
       </article>

       <div class="three">
           <table>
               <tr>
                   <td>
                    <h2>privacy</h2>
                   </td>
                   <td>
                    <h2>Account</h2>
                   </td>
                   <td>
                    <h2>unsubscribe</h2>
                   </td>
               </tr>
           </table>
       </div>

       <article class="last">
           <button>
            <img src="{{ asset('images/Vector (5).png') }}" />
           </button>

       </article>
    </article>


    {{--  <i class="fa fa-facebook"></i>  --}}
</div>

</body>
</html>
