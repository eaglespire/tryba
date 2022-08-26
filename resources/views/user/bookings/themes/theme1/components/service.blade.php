<section class="bg-gray-50">
    <div class="container mx-auto p-16" >
        <h1 class="font-semibold text-4xl" >My services</h1>
        <p class="my-3" >You can book service from the cart view easily</p>

        <div class="grid grid-cols-3 gap-4 my-10"  >

            @foreach ($data->services as $service)
                <div class="shadow-lg rounded-lg border overflow-auto bg-white">
                    <div><img src="{{ url('/') }}/{{ $service->image }}" class="h-48 w-full" alt=""></div>
                    <div class="p-4" >
                        <p class="font-semibold" >{{ $service->name }}</p>
                        <p class="font-semibold my-2 text-sm" >{!! $service->description !!}</p>
                        <div class="flex items-center space-x-4 my-4">
                            <div><i class="fal fa-stopwatch text-3xl brand-text"></i></div>
                            <div>
                                <p class="text-xs" >Duration</p>
                                <p class="text-sm" >{{ $service->duration }} {{ str_plural($service->durationType) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 my-4">
                            <div><i class="fal fa-usd-circle text-3xl brand-text"></i></div>
                            <div>
                                <p class="text-xs" >Price</p>
                                <p class="text-sm" >{{ number_format($service->price) }} </p>
                            </div>
                        </div>
                
                        <button class="brand px-4 py-2 my-4 rounded text-gray-100 text-sm"  >{{ $data->appearance->actionText }}</button>
                    </div>
                </div>
            @endforeach
        </div>  
    </div>
</section>