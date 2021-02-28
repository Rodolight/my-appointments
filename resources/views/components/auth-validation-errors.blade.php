@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="text-center font-medium text-red-600">
            {{ __('Whoops! Se produjo un error.') }}
        </div>
        <div class="alert alert-danger" role="alert">
            
            <ul class="list-disc text-xs text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    </div>

@endif
