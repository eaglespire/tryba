@component('mail::message')
<h4>Hi {{ $user->first_name }},</h4>
  <p>Customer Name : {{ $data['name'] }} </p>
  <p>Customer Email : {{ $data['email'] }} </p>
  <p>Customer phone : {{ $data['phone'] }} </p>
  <p>Customer Message : {{ $data['message'] }} </p>
  <br>
  <br>
 <p>
 Best Regards,<br>
 Tryba Business</p>
@endcomponent