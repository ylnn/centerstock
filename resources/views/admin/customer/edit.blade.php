@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.customer') @lang('adminLang.edit')</h2>
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.update', ['customer' => $record->id]) }}">
                {{csrf_field()}}
                
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$record->name}}" autofocus required>
                </div>
                <div class="form-group">
                    <label for="phone">@lang('adminLang.phone')</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{$record->phone}}">
                </div>
                <div class="form-group">
                    <label for="email">@lang('adminLang.email')</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$record->email}}">
                </div>
                <div class="form-group">
                    <label for="area">@lang('adminLang.area')</label>
                    <select name="area_id" id="area_id" class="form-control">
                        <option value="">@lang('adminLang.none')</option>
                        @foreach ($areas as $area)
                            <option @if($area->id == $record->area_id) selected="selected" @endif value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                {{-- <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a> --}}
                <a href="{{route($baseRoute.'.index')}}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ old('previous') ?? url()->previous() }}">
            </form>

        </div>
    </div>
@endsection