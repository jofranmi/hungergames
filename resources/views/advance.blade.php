@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Results') }}</div>

                <div class="card-body">
                    @foreach($results as $result)
                        <event :result="{{ $result->toJson() }}"></event>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
