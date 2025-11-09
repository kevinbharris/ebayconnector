<x-admin::layouts>
    <x-slot:title>
        @lang('ebayconnector::app.products.title')
    </x-slot>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('ebayconnector::app.products.title')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <button 
                type="button" 
                class="primary-button"
                @click="syncAll"
            >
                @lang('ebayconnector::app.products.sync_all')
            </button>
        </div>
    </div>

    <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
        <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">
            <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                <div class="table-responsive grid w-full">
                    <x-admin::table>
                        <x-admin::table.thead>
                            <x-admin::table.thead.tr>
                                <x-admin::table.th>
                                    <input type="checkbox" @change="selectAll">
                                </x-admin::table.th>
                                <x-admin::table.th>@lang('ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('Product Name')</x-admin::table.th>
                                <x-admin::table.th>@lang('SKU')</x-admin::table.th>
                                <x-admin::table.th>@lang('Status')</x-admin::table.th>
                                <x-admin::table.th>@lang('eBay Item ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('Last Synced')</x-admin::table.th>
                                <x-admin::table.th>@lang('Actions')</x-admin::table.th>
                            </x-admin::table.thead.tr>
                        </x-admin::table.thead>

                        <x-admin::table.tbody>
                            @foreach($products as $product)
                                <x-admin::table.tbody.tr>
                                    <x-admin::table.td>
                                        <input type="checkbox" class="product-checkbox" value="{{ $product->id }}">
                                    </x-admin::table.td>
                                    <x-admin::table.td>{{ $product->id }}</x-admin::table.td>
                                    <x-admin::table.td>{{ $product->name }}</x-admin::table.td>
                                    <x-admin::table.td>{{ $product->sku }}</x-admin::table.td>
                                    <x-admin::table.td>
                                        @php
                                            $mapping = $mappings->where('product_id', $product->id)->first();
                                        @endphp
                                        <span class="label label-{{ $mapping ? 'success' : 'secondary' }}">
                                            {{ $mapping ? $mapping->status : 'Not Synced' }}
                                        </span>
                                    </x-admin::table.td>
                                    <x-admin::table.td>{{ $mapping?->ebay_item_id ?? '-' }}</x-admin::table.td>
                                    <x-admin::table.td>{{ $mapping?->last_synced_at?->diffForHumans() ?? '-' }}</x-admin::table.td>
                                    <x-admin::table.td>
                                        <button 
                                            type="button" 
                                            class="secondary-button"
                                            @click="syncProduct({{ $product->id }})"
                                        >
                                            @lang('ebayconnector::app.products.sync')
                                        </button>
                                    </x-admin::table.td>
                                </x-admin::table.tbody.tr>
                            @endforeach
                        </x-admin::table.tbody>
                    </x-admin::table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" class="primary-button" @click="syncSelected">
                        @lang('ebayconnector::app.products.sync_selected')
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>

@push('scripts')
    <script type="module">
        function selectAll(e) {
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        }

        function syncProduct(productId) {
            if (!confirm('@lang("Are you sure you want to sync this product?")')) {
                return;
            }

            window.axios.post('{{ route("ebayconnector.admin.products.sync") }}', {
                product_ids: [productId]
            })
            .then(response => {
                window.emitter.emit('add-flash', { type: 'success', message: response.data.message });
                if (response.data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                window.emitter.emit('add-flash', { type: 'error', message: error.message });
            });
        }

        function syncSelected() {
            const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                .map(checkbox => parseInt(checkbox.value));

            if (selectedIds.length === 0) {
                window.emitter.emit('add-flash', { type: 'warning', message: '@lang("Please select at least one product")' });
                return;
            }

            if (!confirm(`@lang("Are you sure you want to sync") ${selectedIds.length} @lang("products?")`)) {
                return;
            }

            window.axios.post('{{ route("ebayconnector.admin.products.sync") }}', {
                product_ids: selectedIds
            })
            .then(response => {
                window.emitter.emit('add-flash', { type: 'success', message: response.data.message });
                if (response.data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                window.emitter.emit('add-flash', { type: 'error', message: error.message });
            });
        }

        function syncAll() {
            if (!confirm('@lang("Are you sure you want to sync all products? This may take a while.")')) {
                return;
            }

            window.axios.post('{{ route("ebayconnector.admin.products.sync-all") }}')
            .then(response => {
                window.emitter.emit('add-flash', { type: 'success', message: response.data.message });
                location.reload();
            })
            .catch(error => {
                window.emitter.emit('add-flash', { type: 'error', message: error.message });
            });
        }

        // Make functions globally available
        window.selectAll = selectAll;
        window.syncProduct = syncProduct;
        window.syncSelected = syncSelected;
        window.syncAll = syncAll;
    </script>
@endpush
