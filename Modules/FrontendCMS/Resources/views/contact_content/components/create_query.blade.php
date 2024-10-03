<div class="main-title">
    <h3 class="mb-30"> {{__('frontendCms.add_InQuery')}} </h3>
</div>

@include('frontendcms::contact_content.components.query_form',['form_id' => 'add_query_form','form_tab' => 'iq_create','btn_id' => 'create_btn', 'button_name' => __('common.save') ])


