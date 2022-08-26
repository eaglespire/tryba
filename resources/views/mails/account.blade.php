  @component('mail::message')

 <h4>Hi {{ $user->last_name }},</h4><br>

@if(strtolower($decision) === 'approved')
<p>Thank you for submitting your documents.</p>
<p>You have now completed your KYC (Know your Customer) process and your account is fully active!</p>
<p>Setup Tryba for your business: There're many ways your customers can pay you. </p>
<p>You don’t even need to have your own website to receive payments and take your business online.</p>
<p>If you have any question, feel free to reach out to us.</p>
@else
<p>Thank you for submitting your KYC (Know your Customer) documents.</p>
<p>After a careful review, we regret to inform you that your documentation is incomplete and cannot be approved at this time because Suspicious behaviour.</p>
<p>Please be advised that your account is now inactive and you will not be able to accept payments. </p>
<p>The safety and legitimacy of our Merchants and their customers are of utmost importance to us at Tryba.</p>
<p>Please log in to your account to re-submit valid documents to reactivate your account.
<p>If you have any questions, feel free to reach out to us.</p>
@endif
Best Regards,

Tryba Compliance
@endcomponent
