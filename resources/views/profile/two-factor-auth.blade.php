@extends('profile.layouts')

@section('main')

    <form action="{{ route('profile.2fa.manage') }}" method="post">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="type" class="col-form-label">Type</label>
            <select name="type" id="type" class="form-control">
               @foreach(config('twofactor.types') as $key => $name)
                    <option value="{{ $key }}" {{ old('type') == $key || auth()->user()->two_factor_type == $key ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="phone" class="col-form-label" >Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{old('phone') ?? auth()->user()->phone_number }}">
        </div>

        <div class="form-group">
            <button class="btn btn-primary">update</button>
        </div>
    </form>

@endsection
