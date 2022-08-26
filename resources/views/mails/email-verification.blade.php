  @component('mail::message')
 <h4>Hi {{ $user->first_name }},</h4>
  <p> Thanks you for signing up to Tryba. As part of our securtiy checks we need to verify your email address. Simply click on the link below and job done.</p>
  @component('mail::button', ['url' => route('user.confirm-email', ['id' => $code]), 'color' => ''])
    Confirm here
  @endcomponent
  
  Best Regards,<br>
  Tryba Compliance
@endcomponent
