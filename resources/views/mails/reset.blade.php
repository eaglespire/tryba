@component('mail::message')
<h4>Hi {{ $user->first_name }},</h4>
<p>Use this <a href="{{ $code }}" style="padding: 10px; ">link</a> to reset password. <a href="{{ $code }}" style="padding: 10px; ">Reset here</a>
{{-- @component('mail::button', ["url" => $code, "color" => ""])
Confirm here
@endcomponent --}}

<p></p><br/>
Best Regards,<br>
Tryba Compliance
@endcomponent
