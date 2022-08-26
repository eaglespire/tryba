@component('mail::message')
<h4>Hi {{ $user->first_name }},</h4>
  <p>We’ve reviewed your account details, and after careful consideration we’ve decided to close your account. We will email transfer instructions for any funds in your account.</p>
  <p>From now on, you won’t be able to transfer any further funds into your account, and you won’t be able to make payments with your tryba card, or make ATM withdrawals.</p>
  <p>We’re sorry for the inconvenience. We have to close your account to comply with regulatory requirements, as per our terms and conditions.</p>
  <p>Simply click on the link below 
  @component('mail::button', ['url' => 'https://compliance.tryba.io/blocked/'. $slug, 'color' => ''])
    Download data
  @endcomponent
 
 Best Regards,<br>
 Tryba Business Banking
@endcomponent