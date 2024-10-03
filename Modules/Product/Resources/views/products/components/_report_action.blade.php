<!-- shortby  -->
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a class="dropdown-item report-show" href="{{ route('product.showReport',$reason->id) }}">
            Show
        </a>
        <a class="dropdown-item make-private" href="">
            Make Private
        </a>

    </div>
</div>
