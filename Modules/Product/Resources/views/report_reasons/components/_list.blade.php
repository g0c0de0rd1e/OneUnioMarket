<div class="row">
    <div class="col-lg-12">
        <table class="table" id="categoryDataTable">
            <thead>
                <tr>
                    <th scope="col">{{ __('common.id') }}</th>
                    <th scope="col">{{ __('common.name') }}</th>
                    <th scope="col">{{ __('common.status') }}</th>
                    <th scope="col">{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reasons as $reason)
                <tr>
                    <td>{{ $reason->id }}</td>
                    <td>{{ $reason->name }}</td>
                    <td>
                        @if($reason->status == 1)
                         <span class="badge_1">Active</span>
                        @else
                         <span class="badge_2">Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a data-url='{{ route("product.report.edit",$reason->id) }}' class="dropdown-item edit_category">Edit</a>
                                    <a class="dropdown-item delete_brand" data-id="{{ $reason->id }}">Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
