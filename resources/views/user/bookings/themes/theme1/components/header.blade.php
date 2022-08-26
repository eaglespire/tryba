<header id="home" class="bg-white grid grid-cols-2 container mx-auto px-16 py-6" >
    <div>
        <img src="{{ url('/').'/'. $data->logoUrl }}" class="h-20 object-cover" alt="logo">
    </div>
    <div class="flex items-center space-x-8">
        <ul class="flex space-x-8 font-normal">
            <li>
                <a href="javascript:void(0)" id="homeBtn" >Home</a>  
            </li>
            <li>
                <a href="#">Services</a> 
            </li>
            <li>
                <a href="javascript:void(0)" id="contactBtn">Contact</a> 
            </li>
        </ul>
        <div>
            <button class="brand px-6 py-3 rounded text-gray-100"  >{{ $data->appearance->actionText }}</button>
        </div>
    </div>
</header>

<section class="bg-gray-100 py-16">
    <div class="container px-16 py-20 mx-auto">
        <h1 class="text-base mb-2" >Welcome to {{ $data->business_name }} booking store</h1>
        <div class="w-1/2" >
            <p class="text-5xl break-words font-semibold">{{ $data->description }} </p>
        </div>
        <div class="mt-4">
            <button class="brand px-6 py-3 rounded text-gray-100"  >{{ $data->appearance->actionText }}</button>
        </div>
    </div>

</section>