@if ($transaction->txn_id)
    @if ($transaction->txn_id = "None")
        {{__("common.none") }}
    @elseif ($transaction->txn_id == "Added By Admin")
        {{__("wallet.added_by_admin") }}
    @else
    {{ $transaction->txn_id }}
    @endif
@endif
