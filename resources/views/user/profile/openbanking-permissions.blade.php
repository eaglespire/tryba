@extends('user.profile.index')

@section('mainpage')
    @include('user.profile.partials.top', ['title'=>'Open Banking'])
<div class="tab-pane fade @if(route('openbanking.permissions')==url()->current())show active @endif" role="tabpanel">

    <div class="mx-4 my-5">
        <table class="p-10">
            <tr>
                <th>{{__('App Name')}} </th>
                <th>{{__('App Permisions')}} </th>
                <th>{{(__('Action'))}} </th>
            </tr>

            @foreach ($consents as $consent)
                <tr>
                    <td>{{ $consent->TppName }} </td>
                    <td>
                        @if(isset($consent->PaymentType) && $consent->PaymentType !=='')
                            <span>{{ucwords($consent->PaymentType)}} </span>
                        @else <span>{{ucwords($consent->Scope)}} </span>
                        @endif
                    </td>
                    <td>
                        <button onclick="revoke('{{$consent->ConsentId}}');"   class="btn btn-sm btn-danger revoke">REVOKE</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection


@section('script')
        <script>
	// $(document).ready(function() {
       function revoke(id){
        let baseUrl = "{{url('/')}}";
                event.preventDefault();
               let r = confirm('Do you want to revoke permissions?');
            //    let id = event.target.getAttribute('data-consentId');
               if(r){
                window.location = "{{ url('/user/open-banking/user-consents/revoke') }}/"+id;
               }
            }
        // });
        </script>
@endsection
