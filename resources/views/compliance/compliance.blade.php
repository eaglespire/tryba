@extends('compliance.index')

@section('content')
    @if(session('success') ||  $compliance->responded)
    <p class="font-semibold my-8">Thank you for submitting, We would review the document you have provided</p>
    @else
    <div class="font-inter text-sm my-6 px-3">
        <h1 class="font-semibold mb-4">{{ $compliance->subject }}</h1>
        <p class="font-semibold">{{ $compliance->reason  }}</p>
    </div>
    <form action="{{ route('RespondForm',$compliance->url) }}" class="px-3" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <textarea name="response" value="{{ (old('response')) ? old('response') : '' }}" class="border-2 border-gray-100 bg-white text-sm p-3 w-full rounded outline-none" id="" cols="30" rows="10" placeholder="Your response"></textarea>
            @if($errors->has('response'))
                <div class="text-xs text-red-500">{{ $errors->first('response') }}</div>
            @endif
        </div>
        <div class="mt-4 flex justify-center" >
            <label class="flex space-x-2" >
                <div class="px-6 py-2 text-sm border-brand border-2 flex space-x-3 items-center rounded-md bg-white text-brand ">
                    <p>File Upload</p> 
                    <div>
                        <img src="{{ asset('asset/email-asset/document-upload.png') }}" class="h-4 w-4" alt="">
                    </div>
                </div>
                <input type="file" class="hidden" name="file" id="file">
            </label>
        </div>
        <p class="text-xs text-center my-2">Maximum file upload: 20M</p>
        @if($errors->has('file'))
            <div class="text-xs text-red-500">{{ $errors->first('file') }}</div>
        @endif
        <div class="text-center my-6">
            <button class="px-16 py-4 bg-brand text-gray-100 text-sm rounded-md">Submit</button>
        </div>
    </form>
    @endif
@endsection