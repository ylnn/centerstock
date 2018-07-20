@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.create-stock')</h2>
    
    <div class="row">
        <div class="col-6">
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
                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ url()->previous() }}">
            </form>

        </div>
    </div>
@endsection