@component('mail::message')
<h4>Hi {{ $user->first_name }},</h4>
  <p>
        Due to compliance obligations and to safeguard your account, we have decided to suspend your business account. 
  </p>
  <p>
        We will require more information and this process has can be done by clicking on the button below.
  </p>
    @component('mail::button', ['url' => 'https://compliance.tryba.io/'.$slug, 'color' => ''])
    Submit information
    @endcomponent
 
 Best Regards,<br>
 Tryba Compliance
@endcomponent