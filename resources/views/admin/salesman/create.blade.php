@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.create-salesman')</h2>
    
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.store') }}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="status">@lang('adminLang.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Deaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" autofocus required value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="area_id">@lang('adminLang.area')</label>
                    <select name="area_id" id="area_id" class="form-control">
                        @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone">@lang('adminLang.phone')</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
                </div>
                <div class="form-group">
                    <label for="email">@lang('adminLang.email')</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" required>
                </div>
                <div class="form-group">
                    <label for="password">@lang('adminLang.password')</label>
                    <input text="password" class="form-control" id="password" name="password"  value="{{ str_random(8) }}" required>
                </div>
                <div class="form-group">
                    <label for="address">@lang('adminLang.address')</label>
                    <textarea name="address" class="form-control" id="address" cols="30"  rows="4">{{old('address')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="desc">@lang('adminLang.desc')</label>
                    <textarea name="desc" class="form-control" id="desc" cols="30" rows="10">{{old('desc')}}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ url()->previous() }}">
            </form>

        </div>
    </div>
@endsection