@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.product') @lang('adminLang.edit')</h2>
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.update', ['product' => $record->id]) }}">
                {{csrf_field()}}
                
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$record->name}}" autofocus required>
                </div>
                <div class="form-group">
                    <label for="base_price">@lang('adminLang.base_price')</label>
                    <input type="text" class="form-control" id="base_price" name="base_price" value="{{$record->base_price}}">
                </div>

                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                {{-- <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a> --}}
                <a href="{{route($baseRoute.'.index')}}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ old('previous') ?? url()->previous() }}">
            </form>

        </div>
    </div>
@endsection