@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => $url])
{!! $website !!}
@endcomponent
@endslot

{{-- Body --}}
{!! $content !!}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {!! $website !!}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
