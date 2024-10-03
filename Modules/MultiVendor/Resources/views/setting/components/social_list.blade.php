<table class="table Crm_table_active2">
    <thead>
    <tr>
        <th scope="col">{{__('common.sl')}}</th>
        <th scope="col">{{ __('common.url') }}</th>
        <th scope="col">{{ __('common.icon') }}</th>
        <th scope="col" class="text-center">{{ __('common.status') }}</th>
        <th scope="col" class="text-center">{{ __('common.action') }}</th>
    </tr>
    </thead>
    <tbody>
        @foreach($socialLinks as $key => $link)
        <tr>
            <td>{{$key +1}}</td>
            <td><a href="">{{$link->url}}</a></td>
            <td><i class="{{$link->icon}}"></i></td>
            <td><span class="{{$link->status == 1?'badge_1':'badge_2'}}">{{ showStatus($link->status) }}</span></td>
            

            <td>
                <!-- shortby  -->
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('common.select') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">

                        <a href="#" data-value="{{$link}}" class="dropdown-item edit_link">{{ __('common.edit') }}</a>

                        <a href="#" class="dropdown-item delete_link"
                         data-id="{{$link->id}}">{{ __('common.delete') }}</a>

                    </div>
                </div>
                <!-- shortby  -->
            </td>

        </tr>
        @endforeach

    </tbody>
</table>
