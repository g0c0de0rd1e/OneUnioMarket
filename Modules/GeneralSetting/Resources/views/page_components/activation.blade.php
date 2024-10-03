<div class="main-title mb-25">
    <h3 class="mb-0">{{ __('general_settings.activation') }}</h3>
</div>

<div class="common_QA_section QA_section_heading_custom">
    <div class="QA_table ">
        <!-- table-responsive -->
        <div class="">
            <table class="table Crm_table_active2">
                <thead>
                    <tr>
                        <th scope="col">{{__('common.sl')}}</th>
                        <th scope="col">{{ __('common.type') }}</th>
                        <th scope="col" width="10%" class="text-right">{{ __('general_settings.activate') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($others_activations as $key => $others_activation)
                        <tr>
                            <td>{{ getNumberTranslate($key+1) }}</td>
                            <td>
                            @php
                                switch ($others_activation->type) {
                                    case 'email_verification':
                                    echo __("general_settings.email_verification");
                                    break;
                                    case 'sms_verification':
                                    echo __("general_settings.sms_verification");
                                    break;
                                    case 'mail_notification':
                                    echo __("general_settings.mail_notification");
                                    break;
                                    case 'system_notification':
                                    echo __("general_settings.system_notification");
                                    break;
                                }
                            @endphp
                            </td>
                            <td class="text-right">
                                <label class="switch_toggle" for="checkbox{{ $others_activation->id }}">
                                    <input type="checkbox" id="checkbox{{ $others_activation->id }}" @if ($others_activation->status == 1) checked @endif @if (permissionCheck('update_activation_status')) value="{{ $others_activation->id }}" class="activations" @endif>
                                    <div class="slider round"></div>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                    @if(isModuleActive('MultiVendor'))
                        @foreach ($vendor_configurations as $key => $vendor_configuration)
                            <tr>
                                <td>{{ getNumberTranslate($key+1) }}</td>
                                <td>
                                    @php
                                        switch ($vendor_configuration->type) {
                                            case 'Multi-Vendor System Activate':
                                            echo __("general_settings.multivendor_system_activate");
                                            break;
                                        }
                                    @endphp
                                </td>
                                <td class="text-right">
                                    <label class="switch_toggle" for="checkbox{{ $vendor_configuration->id }}">
                                        <input type="checkbox" id="checkbox{{ $vendor_configuration->id }}" @if ($vendor_configuration->status == 1) checked @endif  @if (permissionCheck('update_activation_status')) value="{{ $vendor_configuration->id }}" class="activations" @endif>
                                        <div class="slider round"></div>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
