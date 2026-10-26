<div class="input-group d-flex justify-content-center">
    <input
        wire:model="purchase_price.{{ $cart_item->id }}"
        style="min-width: 40px; max-width: 90px;"
        type="number"
        class="form-control"
        min="0"
        step="0.01"
    >

    <div class="input-group-append">
        <button
            type="button"
            x-on:click="openPurchase{{ $cart_item->id }} = false"
            wire:click="updatePurchasePrice('{{ $cart_item->rowId }}', {{ $cart_item->id }})"
            class="btn btn-info"
        >
            <i class="bi bi-check"></i>
        </button>
    </div>
</div>