<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tgl Awal <span class="text-danger">*</span></label>
                                    <input wire:model="start_date" type="date" class="form-control" name="start_date">
                                    @error('start_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tgl Akhir <span class="text-danger">*</span></label>
                                    <input wire:model="end_date" type="date" class="form-control" name="end_date">
                                    @error('end_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Pelanggan</label>
                                    <select wire:model="customer_id" class="form-control" name="customer_id">
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                Filter Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <!-- <button onclick="exportTableToExcel('table-to-export', 'lap-penjualan-per-produk')" class="btn btn-success">
                        <i class="bi bi-file"></i>
                        Export Excel
                    </button> -->

                    <button
                        type="button"
                        wire:click="exportPdf"
                        wire:loading.attr="disabled"
                        wire:target="exportPdf"
                        class="btn btn-danger">

                        <span wire:loading.remove wire:target="exportPdf">
                            <i class="bi bi-file-pdf"></i>
                            Export PDF
                        </span>

                        <span wire:loading wire:target="exportPdf">
                            <span class="spinner-border spinner-border-sm"></span>
                            Membuat PDF...
                        </span>
                    </button>
                    
                    <hr>
                    
                    <table id="table-to-export" class="table table-bordered table-striped text-center mb-0">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>
                                    @php
                                        $product = \Modules\Product\Entities\Product::find($sale->product_id);
                                        $media = $product?->getFirstMedia('images');
                                    @endphp

                                    @if ($media)
                                        <img
                                            src="{{ url('/media/' . $media->getPathRelativeToRoot()) }}"
                                            alt="{{ $sale->product_name }}"
                                            width="60"
                                            class="img-thumbnail">
                                    @else
                                        <img
                                            src="{{ $product?->product_image_url }}"
                                            alt="{{ $sale->product_name }}"
                                            width="60"
                                            class="img-thumbnail">
                                    @endif
                                </td>
                                <td>{{ $sale->product_name }}</td>
                                <td>{{ $sale->total_qty }} {{ $sale->product_unit }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <span class="text-danger">No Sale Data Available!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div @class(['mt-3' => $sales->hasPages()])>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
