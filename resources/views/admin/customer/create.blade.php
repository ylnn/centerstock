@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.create-customer')</h2>
    
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.store') }}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" autofocus required>
                </div>
                <div class="form-group">
                    <label for="phone">@lang('adminLang.phone')</label>
                    <input type="text" class="form-control" id="phone" value="{{old('phone')}}" name="phone">
                </div>
                <div class="form-group">
                    <label for="email">@lang('adminLang.email')</label>
                    <input type="text" class="form-control" id="email" value="{{old('email')}}" name="email">
                </div>
                <div class="form-group">
                    <label for="area">@lang('adminLang.area')</label>
                    <select name="area_id" id="area_id" class="form-control">
                        <option value="">@lang('adminLang.none')</option>
                        @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ url()->previous() }}">
            </form>

        </div>
    </div>
@endsection