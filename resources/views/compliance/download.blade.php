@extends('compliance.index')

@section('content')
    <div class="font-inter text-sm my-6 px-3">
        <h1 class="font-semibold mb-4">Your Account has been blocked</h1>
        <p class="">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aperiam perspiciatis neque non voluptates assumenda id. Laudantium dolores corrupti nobis iure, dolor, exercitationem alias soluta, neque repudiandae sapiente deleniti at natus!</p>
    </div>
    <form action="{{ route('blocked.download', $blocked->slug) }}" class="px-3 my-4" method="post" enctype="multipart/form-data">
        @csrf
        @if($blocked->isMoneyinAccount)
        <div class="mb-4">
            <input name="accountNumber" value="{{ (old('accountNumber')) ? old('accountNumber') : '' }}" class="border-2 border-gray-100 bg-white text-sm p-3 w-full  rounded outline-none" placeholder="Account Number"/>
            @if($errors->has('accountNumber'))
                <div class="text-xs text-red-500">{{ $errors->first('accountNumber') }}</div>
            @endif
        </div>
        <div>
            <input name="sortCode" value="{{ (old('sortCode')) ? old('sortCode') : '' }}" class="border-2 border-gray-100 bg-white text-sm p-3 w-full rounded outline-none" placeholder="Sort code"/>
            @if($errors->has('sortCode'))
                <div class="text-xs text-red-500">{{ $errors->first('sortCode') }}</div>
            @endif
        </div>
        <div class="text-xs my-2">Account name must match with the full name in our system</div>
        @endif
        <div class="text-center my-6">
            <button class="px-16 py-4 bg-brand text-gray-100 text-sm rounded-md">Download data</button>
        </div>
    </form>
@endsection