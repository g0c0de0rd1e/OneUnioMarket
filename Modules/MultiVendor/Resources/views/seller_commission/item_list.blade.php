<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{__('common.sl')}}</th>
        <th scope="col">{{__('common.name')}}</th>
        <th scope="col">{{__('common.rate')}} (%)</th>
        <th scope="col">{{__('common.status')}}</th>
        <th scope="col">{{__('common.description')}}</th>
        <th scope="col">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key => $item)
        <tr>
            <th>{{ getNumberTranslate($key+1) }}</th>
            <td>{{ $item->name }}</td>
            <td>{{ getNumberTranslate($item->rate) }}</td>
            <td><span class="{{$item->status == 1?'badge_1':'badge_2'}}">{{ showStatus($item->status) }}</span></td>
            <td>{{ Str::limit($item->description,25) }}</td>
            <td>
                @if (permissionCheck('admin.seller_commission_edit'))
                    <!-- shortby  -->
                    <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('common.select')}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                             <a class="dropdown-item edit_item" data-value="{{$item->id}}" type="button">{{__('common.edit')}}</a>
                        </div>
                    </div>
                    <!-- shortby  -->
                @else
                    <button class="primary_btn_2" type="button">{{__('common.no_permission')}}</button>
                @endif
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
