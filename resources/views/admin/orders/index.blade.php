<x-admin::layouts>
    <x-slot:title>
        @lang('ebayconnector::app.orders.title')
    </x-slot>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('ebayconnector::app.orders.title')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <button 
                type="button" 
                class="primary-button"
                @click="syncNewOrders"
            >
                @lang('ebayconnector::app.orders.sync_new')
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
                                <x-admin::table.th>@lang('ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('eBay Order ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('Bagisto Order ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('Status')</x-admin::table.th>
                                <x-admin::table.th>@lang('Last Synced')</x-admin::table.th>
                                <x-admin::table.th>@lang('Actions')</x-admin::table.th>
                            </x-admin::table.thead.tr>
                        </x-admin::table.thead>

                        <x-admin::table.tbody>
                            @forelse($mappings as $mapping)
                                <x-admin::table.tbody.tr>
                                    <x-admin::table.td>{{ $mapping->id }}</x-admin::table.td>
                                    <x-admin::table.td>{{ $mapping->ebay_order_id }}</x-admin::table.td>
                                    <x-admin::table.td>
                                        @if($mapping->order)
                                            <a href="{{ route('admin.sales.orders.view', $mapping->order_id) }}" class="text-blue-600">
                                                {{ $mapping->order->increment_id }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </x-admin::table.td>
                                    <x-admin::table.td>
                                        <span class="label label-{{ $mapping->status === 'synced' ? 'success' : 'warning' }}">
                                            {{ $mapping->status }}
                                        </span>
                                    </x-admin::table.td>
                                    <x-admin::table.td>{{ $mapping->last_synced_at?->diffForHumans() ?? '-' }}</x-admin::table.td>
                                    <x-admin::table.td>
                                        <button 
                                            type="button" 
                                            class="secondary-button"
                                            @click="syncOrder('{{ $mapping->ebay_order_id }}')"
                                        >
                                            @lang('Re-sync')
                                        </button>
                                    </x-admin::table.td>
                                </x-admin::table.tbody.tr>
                            @empty
                                <x-admin::table.tbody.tr>
                                    <x-admin::table.td colspan="6" class="text-center">
                                        @lang('No orders found')
                                    </x-admin::table.td>
                                </x-admin::table.tbody.tr>
                            @endforelse
                        </x-admin::table.tbody>
                    </x-admin::table>
                </div>

                <div class="mt-4">
                    {{ $mappings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>

@push('scripts')
    <script type="module">
        function syncOrder(ebayOrderId) {
            if (!confirm('@lang("Are you sure you want to sync this order?")')) {
                return;
            }

            window.axios.post('{{ route("ebayconnector.admin.orders.sync") }}', {
                ebay_order_id: ebayOrderId
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

        function syncNewOrders() {
            if (!confirm('@lang("Are you sure you want to sync new orders from eBay?")')) {
                return;
            }

            window.axios.post('{{ route("ebayconnector.admin.orders.sync-new") }}')
            .then(response => {
                window.emitter.emit('add-flash', { type: 'success', message: response.data.message });
                location.reload();
            })
            .catch(error => {
                window.emitter.emit('add-flash', { type: 'error', message: error.message });
            });
        }

        // Make functions globally available
        window.syncOrder = syncOrder;
        window.syncNewOrders = syncNewOrders;
    </script>
@endpush
