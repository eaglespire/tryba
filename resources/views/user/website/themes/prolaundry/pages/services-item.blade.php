@extends('user.website.themes.prolaundry.layout')

@section('content')
@include('user.website.themes.prolaundry.components.breadcrumb')
<main id="tt-pageContent">
	<div class="lazyload subpage-bg-left subpage-bg__position04" data-bg="images/wrapper-subpage-left04.png">
		<div class="lazyload subpage-bg-right subpage-bg__position04" data-bg="images/wrapper-subpage-right04.png">
			<div class="section-inner">
				<div class="container container-fluid-lg">
					<div class="row flex-sm-row-reverse">
						<div class="col-12 col-md-7 col-lg-8">
							<div class="services-item">
								<div class="services-item__img">
									<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="lazyload" data-src="{{ $service->image }}" alt="">
								</div>
								<div class="services-item__layout">
									<div class="tt-selected-block">
										<div class="title-block">
											<div class="title-block__label">
												[ What we offer ]
											</div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h4 class="title-block__title">
                                                            {{ $service->name  }}
                                                        </h4>
                                                        <div>
                                                            <div class="rounded-circle d-flex justify-content-center align-items-center circle-height mr-2 mr-lg-5">
                                                                <p class="text-white fs-1">{{ getUserCurrency($service->user) }}{{ $service->price  }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										</div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="mt-1"><i class="icons-59252"></i> </div>
                                                    <div class="ml-2">{{ $service->duration }} {{ pluarize($service->durationType,$service->duration) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="tt-subtitle indent-top-lg tt-subtitle__large">
                                            Description
                                        </h4>
										<p>
											{{ $service->description }}
										</p>

                                        <h4 class="tt-subtitle indent-top-lg tt-subtitle__large">
                                            Select your desired time
                                        </h4>
                                        <form action="{{ route('website.addtoCart',['id' => $website->websiteUrl,'service' => $service->id]) }}" method="post">
                                            @csrf
                                            <div class="form-group my-3">
                                                <input type="date" id="mydate" name="date" class="date-picker" value="{{ date('Y-m-d') }}" min="{{  date('Y-m-d') }}" max="{{ now()->addMonths(1)->format('Y-m-d')}}" required >
                                            </div>
                                            <div class="form-group my-3">
                                                <select name="time" id="timePicker" class="time-picker" required>
                                                    <option value="">Select your convenient time</option>
                                                    @foreach(getCurrentDateWorkingHours($website->id) as $item)
                                                        <option value="{{ $item }}">{{ ($item > 11) ? ($item == 12) ? $item." PM" : $item - 12 . " PM": $item . " AM"  }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="tt-btn btn__color01 tt-btn__wide">
                                                <span class="mask">Book an appointment</span>
                                                <button type="submit" class="button">Book an appointment</button>
                                            </div>
                                        </form>
									</div>
								</div>
							</div>
						</div>
						<div class="divider d-block d-block d-md-none"></div>
						@include('user.website.themes.prolaundry.components.sidebar')
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

@section('script')
<script>
    let date = document.querySelector('#mydate')

    date.addEventListener('change',(e)=>{
        fetch("{{ route('website.getworkingHours',$website->id) }}", {
            method: 'POST',
            headers: {
                'content-type': 'application/json'
            },
            body: JSON.stringify({
                date: date.value,
                _token: "{{ csrf_token() }}",
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
           let options = data 
           let timePicker = document.querySelector('#timePicker')
           timePicker.innerHTML = ""
           let newOption = new Option("Select your convenient time","");
           timePicker.add(newOption,undefined);
            options.forEach(item => {
                let view = (item > 11) ? (item == 12) ? item + ' PM' : item - 12 + ' PM' : item + ' AM';
                let newOption = new Option(view,item);
                timePicker.add(newOption,undefined);
            })
        })
    })
   
</script>

@endsection