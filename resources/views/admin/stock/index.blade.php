@extends('layout.admin')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">

      <div class="mb-1">
          <h2>@lang('adminLang.stocks')</h2>
          <h4 class="alert alert-info">{{$product->name}}</h4>
      </div>

      <div class="btn-toolbar mb-2 mb-md-0">
        
        <div class="btn-group mr-2">
        <a href="{{ route('admin.stock.create', ['product' => $product->id]) }}" class="btn btn-sm btn-outline-secondary">+ @lang('adminLang.new')</a>
        </div>
      </div>
    </div>

    <div class="controls">
      
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th><a href="?q={{$q}}&sort=serial&direction=@php echo $direction == 'ASC' ? 'DESC' : 'ASC'; @endphp">@lang('adminLang.serial') </a></th>
              <th>@lang('adminLang.product-name')</th>
              <th><a href="?q={{$q}}&sort=quantity&direction=@php echo $direction == 'ASC' ? 'DESC' : 'ASC'; @endphp">@lang('adminLang.quantity')</a></th>
              <th><a href="?q={{$q}}&sort=purchase_price&direction=@php echo $direction == 'ASC' ? 'DESC' : 'ASC'; @endphp">@lang('adminLang.purchase_price')</a></th>
              <th><a href="?q={{$q}}&sort=sale_price&direction=@php echo $direction == 'ASC' ? 'DESC' : 'ASC'; @endphp">@lang('adminLang.sale_price')</a></th>
              <th><a href="?q={{$q}}&sort=expiration_at&direction=@php echo $direction == 'ASC' ? 'DESC' : 'ASC'; @endphp">@lang('adminLang.expiration')</a></th>
              <th class="text-right">@lang('adminLang.actions')</th>
            </tr>
          </thead>
          <tbody>
            @isset($records)
              @forelse ($records as $record)
                <tr>
                  <td>{{$record->serial}}</td>
                  <td>{{optional($record->product)->name}}</td>
                  <td>{{$record->quantity}}</td>
                  <td>{{ $record->purchase_price / 100}}</td>
                  <td>{{$record->sale_price / 100}}</td>
                  <td>{{ \Carbon\Carbon::parse($record->expiration_at)->format('d/m/Y') }}</td>
                  <td class="">
                    <div class="d-flex justify-content-end">
                      <span class="flex mr-1">
                        <a href="{{ route('admin.stock.show', ['product' => $product->id, 'stock' => $record->id]) }} " class="btn btn-primary btn-sm">@lang('adminLang.show')</a>
                      </span>
                      <span class="flex mr-1">
                        <a href="{{ route('admin.stock.edit', ['product' => $product->id, 'stock' => $record->id]) }} " class="btn btn-warning btn-sm">@lang('adminLang.edit')</a>
                      </span>
                      <span class="flex">
                        <form onsubmit="return deleteItem()" style="display"  method="POST" action="{{ route('admin.stock.delete', ['product' => $product->id, 'stock' => $record->id]) }}">
                          {{csrf_field()}}
                          <button type="submit" class="btn btn-danger btn-sm">@lang('adminLang.delete')</button>
                        </form>
                      </span>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7">
                    <div class="p-4">
                      <p>@lang('adminLang.not-found')</p>
                      <a name="" id="" class="btn btn-secondary btn-sm" href="{{ route('admin.stock.create', ['product' => $product->id]) }}" role="button">@lang('adminLang.new')</a>

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