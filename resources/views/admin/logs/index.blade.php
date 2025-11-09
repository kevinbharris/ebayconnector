<x-admin::layouts>
    <x-slot:title>
        @lang('ebayconnector::app.logs.title')
    </x-slot>

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('ebayconnector::app.logs.title')
        </p>

        <div class="flex gap-x-2.5 items-center">
            <button 
                type="button" 
                class="secondary-button"
                @click="clearLogs"
            >
                @lang('ebayconnector::app.logs.clear')
            </button>
        </div>
    </div>

    <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
        <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">
            <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                <div class="mb-4">
                    <form method="GET" action="{{ route('ebayconnector.admin.logs.index') }}" class="flex gap-2">
                        <x-admin::form.control-group.control
                            type="select"
                            name="type"
                            class="control"
                        >
                            <option value="">@lang('All Types')</option>
                            <option value="product" {{ request('type') === 'product' ? 'selected' : '' }}>@lang('Product')</option>
                            <option value="order" {{ request('type') === 'order' ? 'selected' : '' }}>@lang('Order')</option>
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.control
                            type="select"
                            name="status"
                            class="control"
                        >
                            <option value="">@lang('All Statuses')</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>@lang('Success')</option>
                            <option value="error" {{ request('status') === 'error' ? 'selected' : '' }}>@lang('Error')</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                        </x-admin::form.control-group.control>

                        <button type="submit" class="secondary-button">@lang('Filter')</button>
                    </form>
                </div>

                <div class="table-responsive grid w-full">
                    <x-admin::table>
                        <x-admin::table.thead>
                            <x-admin::table.thead.tr>
                                <x-admin::table.th>@lang('ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('Type')</x-admin::table.th>
                                <x-admin::table.th>@lang('Action')</x-admin::table.th>
                                <x-admin::table.th>@lang('Entity ID')</x-admin::table.th>
                                <x-admin::table.th>@lang('Status')</x-admin::table.th>
                                <x-admin::table.th>@lang('Message')</x-admin::table.th>
                                <x-admin::table.th>@lang('Created At')</x-admin::table.th>
                            </x-admin::table.thead.tr>
                        </x-admin::table.thead>

                        <x-admin::table.tbody>
                            @forelse($logs as $log)
                                <x-admin::table.tbody.tr>
                                    <x-admin::table.td>{{ $log->id }}</x-admin::table.td>
                                    <x-admin::table.td>
                                        <span class="label label-info">{{ $log->type }}</span>
                                    </x-admin::table.td>
                                    <x-admin::table.td>{{ $log->action }}</x-admin::table.td>
                                    <x-admin::table.td>{{ $log->entity_id ?? '-' }}</x-admin::table.td>
                                    <x-admin::table.td>
                                        <span class="label label-{{ $log->status === 'success' ? 'success' : ($log->status === 'error' ? 'danger' : 'warning') }}">
                                            {{ $log->status }}
                                        </span>
                                    </x-admin::table.td>
                                    <x-admin::table.td>{{ Str::limit($log->message, 50) }}</x-admin::table.td>
                                    <x-admin::table.td>{{ $log->created_at->diffForHumans() }}</x-admin::table.td>
                                </x-admin::table.tbody.tr>
                            @empty
                                <x-admin::table.tbody.tr>
                                    <x-admin::table.td colspan="7" class="text-center">
                                        @lang('No logs found')
                                    </x-admin::table.td>
                                </x-admin::table.tbody.tr>
                            @endforelse
                        </x-admin::table.tbody>
                    </x-admin::table>
                </div>

                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>

@push('scripts')
    <script type="module">
        function clearLogs() {
            if (!confirm('@lang("Are you sure you want to clear old logs?")')) {
                return;
            }

            window.axios.post('{{ route("ebayconnector.admin.logs.clear") }}')
            .then(response => {
                window.emitter.emit('add-flash', { type: 'success', message: response.data.message });
                location.reload();
            })
            .catch(error => {
                window.emitter.emit('add-flash', { type: 'error', message: error.message });
            });
        }

        // Make function globally available
        window.clearLogs = clearLogs;
    </script>
@endpush
