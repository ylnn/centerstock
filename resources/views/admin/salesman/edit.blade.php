@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.salesman') @lang('adminLang.edit')</h2>
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.update', ['salesman' => $record->id]) }}">
                {{csrf_field()}}
                
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$record->name}}" autofocus required>
                </div>
                <div class="form-group">
                    <label for="desc">@lang('adminLang.desc')</label>
                    <textsalesman name="desc" class="form-control" id="desc" cols="30" rows="10">{{$record->phone}}</textsalesman>
                </div>

                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                {{-- <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a> --}}
                <a href="{{route($baseRoute.'.index')}}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ old('previous') ?? url()->previous() }}">
            </form>

        </div>
    </div>
@endsection