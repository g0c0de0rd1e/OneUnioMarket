@foreach ($cloud_hosts as $key => $host)
    <li>
        <label class="primary_checkbox d-flex mr-12 ">
            <input class="file_storage" data-type="{{$host->type}}" name="file_storage" type="radio" id="file_host{{ $key }}" value="{{ $host->id }}" @if ($host->status != 0) checked @endif>
            <span class="checkmark"></span>
        </label>
        <p>{{ $host->type }}</p>
    </li>
@endforeach