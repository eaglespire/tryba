  @component('mail::message')

 Hi Admin,<br>

<p>Find below registration user</p>

<table>
<tr>
<td>Name:</td>
<td>{{$user->first_name}}</td>
</tr>
<tr>
<td>Agent ID:</td>
<td>{{$user->id}}</td>
</tr>
<tr>
<td>Email:</td>
<td>{{$user->email}}</td>
</tr>
<tr>
<td>Phone Number:</td>
<td>{{$user->phone}}</td>
</tr>
<tr>
</table>



Best Regards,
@endcomponent
