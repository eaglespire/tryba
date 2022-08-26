@extends('user.website.themes.prolaundry.layout')

@section('content')
@include('user.website.themes.prolaundry.components.breadcrumb')
<main id="tt-pageContent">
	<div class="section-inner">
		<div class="container container-fluid-lg">
			<div class="title-block">
				<div class="title-block__label">
					[ We'll deliver our promise ]
				</div>
				<h4 class="title-block__title">
					Your cart
				</h4>
			</div>
		</div>
        <div class="container">
            <table class="table w-100 table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Appointment</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date</th>
                    <th scope="col">Remove</th>
                  </tr>
                </thead>
                <tbody>
                    @if(count(getWebsiteCart()))
                        @foreach(getWebsiteCart() as $key => $item)
                            <tr>
                                <th scope="row my-5">{{ $key + 1}}</th>
                                <td class="py-3">{{ $item->service->name }}</td>
                                <td class="py-3">{{ getUserCurrency($website->user) }} {{ $item->service->price }}</td>
                                <td class="py-3">{{ date("M, d Y", strtotime($item->date)) }}  {{($item->time > 11) ? ($item->time == 12) ? $item->time . ':00 PM' : $item->time - 12 . ':00 PM' : $item->time . ':00 AM' }}</td>
                                <td class="py-3">
                                    <form method="post" action="{{ route('remove.item.cart', ['id' => $website->websiteUrl , 'service' => $item->service->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <a class="tt-btn btn__color01 ">
                                            <span class="mask"><i class="icons-860796" ></i></span>
                                            <button type="submit" class="button"><i class="icons-860796" ></i></button>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-3" >No Appointment in cart</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <a href="#" class="tt-btn btn__color01 tt-btn__top">
                <span class="mask">Check out services</span>
                <div class="button">Check out services</div>
            </a>
            <a href="#" class="tt-btn btn__color01 tt-btn__top">
                <span class="mask">Apply cupon</span>
                <div class="button">Apply cupon</div>
            </a>
        </div>
        <div class="container container-fluid-lg">
            <div class="row">
                <div class="col-sm-6">
                    <h4></h4>
                </div>

            </div>
		</div>
	</div>
</main>
@endsection

@section('script')
<script>
    let form = document.querySelector('#contact');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();     
        let name = document.querySelector('#name');
        let email = document.querySelector('#email');
        let phone = document.querySelector('#phone');
        let error = document.querySelector('#error');
        let success = document.querySelector('#success');
        let message = document.querySelector('#message');
        error.innerText = "";
        const res = await fetch("{{ route('website.contact',$website->websiteUrl) }}", {
            method: 'POST',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            },
            body: JSON.stringify({
               "_token": "{{ csrf_token() }}",
               name:name.value,
               email:email.value,
               phone:phone.value,
               message:message.value
            })
        });

        let data = await res.json();
        if(res.status == 200){
            success.innerText = data.success
        }else{
            error.innerText = data.error
        }
    });
</script>
@endsection