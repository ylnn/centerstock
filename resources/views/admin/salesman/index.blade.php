@extends('layout.admin')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">@lang('adminLang.salesmans')</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        
        <div class="btn-group mr-2">
        <a href="{{ route('admin.salesman.create') }}" class="btn btn-sm btn-outline-secondary">+ @lang('adminLang.new')</a>
        </div>
      </div>
    </div>

    <div class="controls">
      <form method="get" class="inline-form">
        <div class="search-form">
          <div class="row">
            <div class="col-3">
              <input type="text" class="form-control" name="q" value="{{$q ?? ''}}" placeholder="@lang('adminLang.search')...">
            </div>
            <div class="col-3">
                <select name="area_id" id="area_id" class="form-control">
                  <option value="0">@lang('adminLang.area'): @lang('adminLang.all')</option>
                    @foreach ($areas as $area)
                        <option value="{{$area->id}}" @if($area->id == $area_id) selected="selected" @endif>{{$area->name}}</option>
                    @endforeach
                </select>
              </div>
            <div class="col-2">
              <button type="submit" class="btn btn-primary btn-sm">@lang('adminLang.apply-filter')</button>
              <a class="btn btn-warning btn-sm" href="{{route($baseRoute . '.index')}}">@lang('adminLang.reset')</a>
            </div>
          </div>
          <input type="hidden" name="sort" value="{{$sort ?? ''}}"></input>
          <input type="hidden" name="direction" value="{{$direction ?? ''}}"></input>
        </div>
      </form>
      
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th><a href="?q={{$q}}&sort=name&direction=@php echo $direction == 'ASC' ? 'DESC' : 'ASC'; @endphp">@lang('adminLang.name') </a></th>
              <th>@lang('adminLang.area')</th>
              <th class="text-right">@lang('adminLang.actions')</th>
            </tr>
          </thead>
          <tbody>
            @isset($records)
              @forelse ($records as $record)
                <tr>
                  <td>{{$record->name}}</td>
                  <td>{{$record->area->name}}</td>
                  <td class="">
                    <div class="d-flex justify-content-end">
                      <span class="flex mr-1">
                        <a href="{{ route($baseRoute . '.show', [$record->id]) }} " class="btn btn-primary btn-sm">@lang('adminLang.show')</a>
                      </span>
                      <span class="flex mr-1">
                        <a href="{{ route($baseRoute . '.edit', [$record->id]) }} " class="btn btn-warning btn-sm">@lang('adminLang.edit')</a>
                      </span>
                      <span class="flex">
                        <form onsubmit="return deleteItem()" style="display"  method="POST" action="{{ route($baseRoute . '.delete', [$record->id]) }}">
                          {{csrf_field()}}
                          <button type="submit" class="btn btn-danger btn-sm">@lang('adminLang.delete')</button>
                        </form>
                      </span>
                    </div>
                    <!-- <a href="{{ route($baseRoute . '.delete', [$record->id]) }}" class="btn btn-danger btn-sm">@lang('adminLang.delete')</a> -->
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4">
                    <div class="p-4">
                      <p>@lang('adminLang.not-found')</p>
                      <a name="" id="" class="btn btn-secondary btn-sm" href="{{ route( $baseRoute . '.create') }}" role="button">@lang('adminLang.new')</a>

                    </div>
                  </td>
                </tr>
              @endforelse
            @endif
          </tbody>
        </table>


        {{ $records->appends(request()->query())->links() }}

      </div>
@endsection

@push('scripts')
  <script>
    function deleteItem(e) {
        if (confirm("@lang('adminLang.are-you-sure')")) {
            console.log('DELETE-OK');
            return true;
        }
        return false;
    }
  </script>
@endpush