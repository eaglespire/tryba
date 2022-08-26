@component('mail::message')
<h4>Hi {{ $user->first_name }},</h4>
<p>We’ve have reviewed the document you have sent us and account has been activated</p>

<p>
    Best Regards,<br>
    Tryba Compliance
</p>
@endcomponent