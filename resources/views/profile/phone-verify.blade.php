@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                       Active Phone Number
                    </div>

                    <div class="card-body">

                        <form action="{{ route('profile.2fa.phone') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="token">Token</label>
                                <input type="text" id="token" name="token" class="form-control @error('token')is-invalid @enderror">
                                @error('token')
                                     <span class="invalid-feedback">
		                                 <strong>{{ $message }}</strong>
                                     </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Validate Token</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
