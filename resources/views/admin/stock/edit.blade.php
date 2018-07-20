@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.stock') @lang('adminLang.edit')</h2>
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.update', ['product' => $product->id, 'stock' => $record->id]) }}">
                {{csrf_field()}}
                
                <div class="form-group">
                    <label for="product-name">@lang('adminLang.product-name')</label>
                    <p>{{$record->product->name}}</p>
                </div>
                <div class="form-group">
                    <label for="serial">@lang('adminLang.serial')</label>
                    <input type="text" class="form-control" id="serial" name="serial" value="{{$record->serial}}" autofocus required>
                </div>
                <div class="form-group">
                    <label for="quantity">@lang('adminLang.quantity')</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{$record->quantity}}" autofocus required>
                </div>

                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                {{-- <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a> --}}
                <a href="{{route('admin.stock.index', ['product' => $product->id])}}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ old('previous') ?? url()->previous() }}">
            </form>

        </div>
    </div>
@endsection