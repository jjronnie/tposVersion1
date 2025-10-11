<x-app-layout>


                <!-- Link to POS Interface -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('sales.create') }}" class="btn">
                        + {{ __('New Sale (POS)') }}
                    </a>
                </div>

                <x-table :headers="['Invoice #', 'Date', 'Customer', 'Total', 'Paid', 'Status', 'Created By', ]" showActions="true">
                    @foreach ($sales as $sale)
                        <x-table.row>
                            <x-table.cell>
                                <a href="{{ route('sales.show', $sale) }}" >
                                    {{ $sale->invoice_number }}
                                </a>
                            </x-table.cell>
                            
                            <x-table.cell>{{ $sale->sale_date?->format('Y-m-d H:i') ?? $sale->created_at->format('Y-m-d H:i') }}</x-table.cell>
                            
                            <x-table.cell>{{ $sale->customer->name ?? 'Walk-in Customer' }}</x-table.cell>
                            
                            <x-table.cell class="font-bold">${{ number_format($sale->grand_total, 2) }}</x-table.cell>
                            
                            <x-table.cell>${{ number_format($sale->amount_paid, 2) }}</x-table.cell>
                            
                            <x-table.cell>
                                
                                <x-status-badge :status="$sale->payment_status" />
                            </x-table.cell>

                            <x-table.cell>{{ $sale->creator->name ?? 'System' }}</x-table.cell>
                            
                            <x-table.cell>
                                <a href="{{ route('sales.show', $sale) }}" class="btn-sm">View</a>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table>

                <div class="mt-4">
                    {{ $sales->links() }}
                </div>
        
</x-app-layout>
