@extends('layout.admin')

@section('content')
    <h2>@lang('adminLang.create-area')</h2>
    
    <div class="row">
        <div class="col-6">
        <form method="POST" action="{{ route($baseRoute . '.store') }}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">@lang('adminLang.name')</label>
                    <input type="text" class="form-control" id="name" name="name" autofocus required>
                </div>
                <div class="form-group">
                    <label for="desc">@lang('adminLang.desc')</label>
                    <textarea name="desc" class="form-control" id="desc" cols="30" rows="10"></textarea>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('adminLang.cancel')</a>
                <button type="submit" class="btn btn-primary">@lang('adminLang.save')</button>
                <input type="hidden" name="previous" value="{{ url()->previous() }}">
            </form>

        </div>
    </div>
@endsection