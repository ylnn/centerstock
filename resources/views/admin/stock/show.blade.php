@extends('layout.admin') 
@section('content')
<h2>@lang('adminLang.stock'): {{$record->name}} </h2>

<div class="row">
    <div class="col-6">
        <table class="table table-hover">
            <tr>
                <td>
                    @lang('adminLang.serial')
                </td>
                <td>
                    {{$record->serial}}
                </td>
            </tr>
            <tr>
                <td>
                    @lang('adminLang.product-name')
                </td>
                <td>
                    {{$record->product->name}}
                </td>
            </tr>
            
        </table>
    </div>
</div>

<p>
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">@lang('adminLang.back')</a>
    <a href="{{ route($baseRoute . '.edit', ['product' => $product->id,'id' => $record->id]) }} " class="btn btn-warning btn-sm">@lang('adminLang.edit')</a>
</p>
@endsection