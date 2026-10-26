<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit="generateReport">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input wire:model="start_date" type="date" class="form-control" name="start_date">
                                    @error('start_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <input wire:model="end_date" type="date" class="form-control" name="end_date">
                                    @error('end_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select wire:model="customer_id" class="form-control" name="customer_id">
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select wire:model="sale_status" class="form-control" name="sale_status">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Shipped">Shipped</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select wire:model="payment_status" class="form-control" name="payment_status">
                                        <option value="">Select Payment Status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                        <option value="Partial">Partial</option>
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

                    <button
                        type="button"
                        wire:click="exportPdf"
                        wire:loading.attr="disabled"
                        wire:target="exportPdf"
                        class="btn btn-danger mb-3">

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

                    {{-- Wrapper untuk membuat tabel responsive --}}
                    <div class="table-responsive position-relative">

                        {{-- Loading overlay --}}
                        <div
                            wire:loading.flex
                            wire:target="exportPdf"
                            class="position-absolute justify-content-center align-items-center"
                            style="top:0;right:0;left:0;bottom:0;
                                background-color:rgba(255,255,255,0.5);
                                z-index:99;">

                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <table id="table-to-export"
                            class="table table-bordered table-striped mb-0">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>List Belanja</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($sales as $sale)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($sale->created_at)
                                                ->timezone('Asia/Jakarta')
                                                ->locale('id')
                                                ->translatedFormat('d F Y H:i:s') }}
                                        </td>

                                        <td>
                                            {{ $sale->customer_name }}
                                        </td>

                                        <td>
                                            <ol class="mb-0 ps-3">
                                                @foreach ($sale->saleDetails as $detail)
                                                    <li>
                                                        {{ $detail->product->product_name ?? 'Produk tidak ditemukan' }}
                                                        ({{ number_format($detail->quantity, 0, ',', '.') }})
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </td>

                                        <td class="text-end text-nowrap">
                                            {{ format_currency($sale->total_amount) }}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">
                                            No Sales Data Available!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div @class(['mt-3' => $sales->hasPages()])>
                        {{ $sales->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
