<table class="table Crm_table_active2">
    <thead>
    <tr>
        <th scope="col">{{__('common.id')}}</th>
        <th scope="col">{{__('shipping.logo')}}</th>
        <th scope="col">{{__('shipping.method_name')}}</th>
        <th scope="col">{{__('shipping.phone')}}</th>
        <th scope="col">{{__('shipping.shipment_time')}}</th>
        <th scope="col">{{__('shipping.cost')}}</th>
        <th scope="col">{{__('common.action')}}</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($unapproved_shipping_methods as $key => $unapproved_method)
            <tr>
                <th>{{ $key+1 }}</th>
                <td>
                    <img class="mini_logo" src="{{showImage($unapproved_method->logo??'backend/img/default.png')}}" alt="{{$unapproved_method->method_name}}">
                </td>
                <td>{{ $unapproved_method->method_name }}</td>
                <td>{{ $unapproved_method->phone }}</td>
                <td>{{ $unapproved_method->shipment_time }}</td>
                <td>{{ single_price($unapproved_method->cost) }}</td>
                <td>
                    @if ($unapproved_method->id > 1 and $unapproved_method->is_approve == 0)
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{__('common.select')}}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a class="dropdown-item delete_methodShipping" data-id="{{$unapproved_method->id}}">{{__('common.delete')}}</a>
                            </div>
                        </div>
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
