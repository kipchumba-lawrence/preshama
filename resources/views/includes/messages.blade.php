@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-light-danger border-0 mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
            <strong>Error!</strong>
            {{ $error }}
        </div>
    @endforeach
@endif

{{-- for success message --}}

@if(session('success'))
    <div class="alert alert-light-success border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
        <strong>Success!</strong>
        {{ session('success') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-light-warning border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
        <strong>Warning!</strong>
        {{ session('warning') }}
    </div>
@endif

{{-- for error message --}}
@if(session('error'))
    <div class="alert alert-light-danger border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
        <strong>Error!</strong>
        {{ session('error') }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-light-success border-0 mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
        <strong>Success!</strong>
        {{ session('success') }}
    </div>
@endif

@if (session('subscribe'))
    <p class="text-success">{{ session('subscribe') }}</p>
@endif
