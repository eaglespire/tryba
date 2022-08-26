@extends('master')

@section('content')
<div class="container-fluid mt--6">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h3 class="mb-0">{{__('Privacy policy')}}</h3>
            </div>
            <div class="card-body">
                <form id="privacy" action="#" method="post">
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <textarea type="text" id="text" class="tinymce form-control">{{ $value->privacy_policy }}</textarea>
                        </div>
                        <input type="hidden" id="input" name="details">
                    </div> 
                    <p class="text-sm" id="message" ></p>               
                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-sm">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div> 
@endsection
@section('script')
    <script>
        let form = document.querySelector('#privacy');
        form.addEventListener('submit',async (e) => {
            e.preventDefault();
            let input = document.querySelector('#input');
            let message = document.querySelector('#message');
            input.value = tinymce.get("text").getContent();

            message.innerText = ""
            const res = await fetch("{{ route('privacy-policy.update') }}", {
                method: 'POST',
                headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    details: input.value,
                })
            });

            let data = await res.json();
            if(res.status == 200){
                message.classList.add('text-success')
                message.innerText = data
            }else{
                message.classList.add('text-danger')
                message.innerText = data
            }
        });
       
    </script>
@endsection