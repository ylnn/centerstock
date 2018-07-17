@extends('layout.admin') 
@section('content')
<h2>@lang('adminLang.product'): {{$record->name}} </h2>

<div class="row">
    <div class="col-6">
        <table class="table table-hover">
            <tr>
                <td>
                    @lang('adminLang.name')
                </td>
                <td>
                    {{$record->name}}
                </td>
            </tr>
            <tr>
                <td>
                    @lang('adminLang.phone')
                </td>
                <td>
                    {{$record->phone}}
                </td>
            </tr>
            <tr>
                <td>
                    @lang('adminLang.email')
                </td>
                <td>
                    {{$record->email}}
                </td>
            </tr>
            
        </table>
    </div>
</div>

<p>
    <!-- <a href="{{ route($baseRoute . '.index') }} " class="btn btn-primary btn-sm">@lang('adminLang.back')</a> -->
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">@lang('adminLang.back')</a>
    <a href="{{ route($baseRoute . '.edit', ['id' => $record->id]) }} " class="btn btn-warning btn-sm">@lang('adminLang.edit')</a>
</p>
@endsection