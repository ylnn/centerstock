@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.salesman') @lang('adminLang.edit')</h2>
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.update', ['salesman' => $record->id]) }}">
                {{csrf_field()}}
                
                <div class="form-group">
                    <label for="status">@lang('adminLang.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" @if($record->status == 1) selected="selected" @endif>Aktif</option>
                        <option value="0" @if($record->status == 0) selected="selected" @endif>Deaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" autofocus required value="{{$record->name}}">
                </div>
                <div class="form-group">
                    <label for="area_id">@lang('adminLang.area')</label>
                    <select name="area_id" id="area_id" class="form-control">
                        @foreach ($areas as $area)
                            <option value="{{$area->id}}" @if($area->id == $record->area_id) selected="selected" @endif>{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone">@lang('adminLang.phone')</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{$record->phone}}">
                </div>
                <div class="form-group">
                    <label for="email">@lang('adminLang.email')</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$record->email}}" required>
                </div>
                <div class="form-group">
                    <label for="address">@lang('adminLang.address')</label>
                    <textarea name="address" class="form-control" id="address" cols="30"  rows="4">{{$record->address}}</textarea>
                </div>
                <div class="form-group">
                    <label for="desc">@lang('adminLang.desc')</label>
                    <textarea name="desc" class="form-control" id="desc" cols="30" rows="10">{{$record->desc}}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                {{-- <a href="{{ old('previous') ?? url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a> --}}
                <a href="{{route($baseRoute.'.index')}}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <input type="hidden" name="previous" value="{{ old('previous') ?? url()->previous() }}">
            </form>

        </div>
    </div>
@endsection