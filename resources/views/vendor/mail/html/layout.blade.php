<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<style>
body {
    background-color: #E6E6E6;
    color: #101010;
    font-family: 'Inter', sans-serif;
    padding:8px;
}
.container{
    min-height: 100vh;
}
p,h4{
    margin: 8px ;
    line-height: 18px;
}
a{
    text-decoration:none;
}
.card{
    background-color: white;
    width: 80%;
    padding: 25px;
    margin: auto;
}
.blue-header{
    background-color: #00AFEF;
    border-radius: 16px;
    padding: 25px;
}
.main-text{
    margin: 40px 20px;
    line-height: 18px;
}
.verify-container{
    display: flex;
    justify-content: center;
}
.verify-code{
    background-color: #00AFEF10;
    padding: 16px;
    color: #00AFEF;
    font-size: 32px;
    font-weight: 600;
    border-radius: 8px;
}
.btn{
    margin: 20px;
    background-color: #00AFEF;
    padding: 16px 48px;
    font-size: 14px;
    color: white;
    outline: none;
    border: 0px;
    border-radius: 8px;
}
.btn-container{
    text-align: center;
    margin: 32px 0px;
}
.flex-type{
    display: flex;
   align-items: center;
  
}
.hw-4{
    height: 1.25rem;
    width: 1.25rem;
    color: #00AFEF;
}
.rounded{
    margin-left: 16px;
    background-color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
}
.btn-text{
    line-height: 18px;
    font-size: 16px;
    padding: 8px 0px;
}
.line-container{
    border-top: 1px solid #00000014;
    border-bottom:  1px solid #00000014;  
    padding: 25px 10px;
    margin: 40px 20px;
}
.margin-left{
    margin-left: 32px;
}
.flex-between{
    margin: 20px 20px;
}
.footer{
    margin: 20px 20px;
    color: #00000090;
    font-size: 11px;
    line-height: 18px;
}
.logo{
    height:25px;
    width:90px;
}
table{
    width: 100%;
    
}
.icon{
    height: 100px;
    width: 120px;
}

@media only screen and (max-width: 1200px) {

    body {
        background-color: #E6E6E6;
        color: #101010;
        font-family: 'Inter', sans-serif;
        padding:8px;
        margin: 0px;
    }
    .card{
        background-color: white;
        width: 80% !important;
        padding: 15px !important;
    }

}
@media only screen and (max-width: 800px) {
    body {
        background-color: #E6E6E6;
        color: #101010;
        font-family: 'Inter', sans-serif;
        padding:8px;
        margin: 0px;
    }
    .card{
        background-color: white;
        width: 90% !important;
        padding: 15px !important;
    }
    .footer{
        margin: 40px 5px !important;
        color: #00000090;
        font-size: 11px !important;
        line-height: 18px !important;
    }
    .flex-between{
        margin: 40px 10px !important;
    }
    .btn{
        background-color: #00AFEF;
        padding: 16px 30px !important;
        font-size: 12px !important;
        color: white;
        outline: none;
        border: 0px;
        border-radius: 8px;
    }
    .line-container{
        border-top: 1px solid #00000014;
        border-bottom:  1px solid #00000014;  
        padding: 25px 10px;
        margin: 40px 10px !important;
    }
    .main-text{
        margin: 20px 0px !important;
        line-height: 18px !important;
        font-size: 12px;
    }
    .margin-left{
        margin-left: 0px !important;
        margin-top: 10px !important;
    }
    p,h4{
        margin: 4px ;
        font-size: 12px;
        line-height: 18px;
    }
    .logo{
        height:15px !important;
        width:60px !important;
        float: left;
    }
    .blue-header{
        background-color: #00AFEF;
        border-radius: 16px;
        padding: 10px !important;
    }
    .icon{
        height: 50px !important;
        width:60px !important;
    }
}
</style>
<body>
    <div class="container">
        <div class="card">
            <div class="blue-header">
                <table>
                    <tr>
                        <td ><img class="logo" src="{{ asset('asset/email-asset/logo.png') }}" alt=""></td>
                        <td style="float: right">
                            <img class="icon" src="{{ asset('asset/email-asset/icon-1.png') }}" alt="">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="main-text">
                {{ Illuminate\Mail\Markdown::parse($slot) }}
            </div>
            <div class="line-container">
                <div style="text-align: center;">
                    <a href="https://apps.apple.com/gb/app/tryba/id1590314942">
                        <img height="40" width="125"  src="{{ asset('asset/email-asset/App Store.png') }}" alt="">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.tryba.io">
                        <img height="40"  width="125" src="{{ asset('asset/email-asset/Google Play.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="flex-between">
                <table>
                    <tr>
                        <td ><img height="20" width="70" src="{{ asset('asset/email-asset/logo-blue.png') }}" alt=""></td>
                        <td style="float:right">
                            <div class="" >
                                <a  href="https://facebook.com/tryba.io"><img height="20" width="20" src="{{ asset('asset/email-asset/facebook.png') }}" alt=""></a>
                                <a style="margin-left: 6px" href="https://twitter.com/IoTryba"><img height="20" width="20" src="{{ asset('asset/email-asset/twitter.png') }}" alt=""></a>
                                <a style="margin-left: 6px" href="https://instagram.com/tryba.io"> <img height="20" width="20" src="{{ asset('asset/email-asset/instagram.png') }}" alt=""></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <p>Your financial security is important to us. We will never include or ask for your card PIN or tryba password in our emails to you. If you’re ever suspicious of an email, please delete it immediately.</p>
                <p>If this email is received by anyone other than the addressee, please delete. Tryba Business Banking does not accept responsibility for changes made to this email after it was sent from us.</p>
                <p>Tryba U.K Limited designs and operates Tryba websites and app, which offers business current accounts and Cards with innovative built-in website and business management tools as a service. Tryba U.K Limited is a financial technology company registered in England and Wales with company number 13509269 and business mailing address at 126 Colmore Row, Birmingham, B3 3AP, United Kingdom.</p>
                <p>Tryba business current accounts and Visa cards are electronic money products issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency. Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573).</p>
                <p>Tryba U.K Limited also act as agent of SafeConnect Ltd for the provision of Open Banking and PISP technology. SafeConnect Ltd is authorised and regulated by the Financial Conduct Authority under the Payment Service Regulations 2017 (827001) for the provision of Account Information and Payment Initiation services.</p>
                <p>© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</p>
            </div>
        </div>
    </div>
</body>
</html>
