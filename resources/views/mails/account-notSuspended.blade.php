@component('mail::message')
<h4>Hi {{ $user->first_name }},</h4>
  <p>Due to compliance obligations, we require more information about a transaction which has occurred on your account. </p>
  <p>Please click on the link below to submit the requested information.</p>
@component('mail::button', ['url' => 'https://compliance.tryba.io/'.$slug, 'color' => ''])
  Submit information
@endcomponent
 
 Best Regards,<br>
 Tryba Compliance
@endcomponent