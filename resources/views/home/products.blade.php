@extends('layouts.app')

@section('script')

@endsection

@section('content')

    <div class="container">
        <div class="row">

            @foreach($products as $product)
                <div class="card col-md-3">

                    <div class="card-header">{{ $product->title }}</div>

                    <div class="card-body">
                        {{ $product->description }}
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-danger" href="/productV2/{{ $product->id }}">جزئیات محصول</a>
                    </div>

                </div>
            @endforeach




        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->withQueryString()->links("pagination::bootstrap-4") }}
        {{--        {{ $home->appends(['search' => request('search')])->links("pagination::bootstrap-4") }}--}}
    </div>
@endsection
