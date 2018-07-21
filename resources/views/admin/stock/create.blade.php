@extends('layout.admin')

@section('content')

<div class="row">
    <div class="col-6">

        <div class="mb-4">
            <h2>@lang('adminLang.create-stock')</h2>
            <h4 class="alert alert-info">{{$product->name}}</h4>
        </div>

        <form method="POST" action="{{ route($baseRoute . '.store', ['product' => $product->id]) }}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="serial">@lang('adminLang.serial')</label>
                    <input type="text" class="form-control" id="serial" name="serial" autofocus required>
                </div>
                <div class="form-group">
                    <label for="quantity">@lang('adminLang.quantity')</label>
                    <input type="text" class="form-control" id="quantity" name="quantity">
                </div>
                <div class="form-group">
                    <label for="purchase_price">@lang('adminLang.purchase_price')</label>
                    <input type="text" class="form-control" id="purchase_price" name="purchase_price">
                </div>
                <div class="form-group">
                    <label for="sale_price">@lang('adminLang.sale_price')</label>
                    <input type="text" class="form-control" id="sale_price" name="sale_price">
                </div>
                <div class="form-group">
                    <label for="user_id">USER (DEĞİŞECEK)</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" value="1">
                </div>
                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ url()->previous() }}">
                <input type="hidden" name="product_id" value="{{$product->id}}">
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    

    
@endpush