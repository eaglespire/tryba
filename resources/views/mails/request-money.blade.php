@component('mail::message')
<h4>Hi {{ $details->first_name }},</h4>
 <p>I am using tryba.io to receive money. All you need to do is click the button below, make payment with card or account and voila! Thanks!"</p>
 @component('mail::button', ['url' => route('requestMoney',$details->slug), 'color' => ''])
   Send Money
 @endcomponent
 
 Best Regards,<br>
 Tryba.io
@endcomponent