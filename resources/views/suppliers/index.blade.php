<x-app-layout>
    <x-page-title />

    <!-- Controls -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                </div>

                <input type="text" id="searchInput"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    placeholder="Search by name...">


            </div>

        </div>
        <div class="flex gap-3">

            <a class="btn" href="{{ route('suppliers.create') }}"> <i data-lucide="plus" class="w-4 h-4 "></i></a>

            <!-- Export to PDF Button -->
            <button class="btn">
                <i data-lucide="file-text" class="w-4 h-4 "></i>
            </button>


            <!-- Export to Excel Button -->
            <button class="btn">
                <i data-lucide="sheet" class="w-4 h-4 "></i>
            </button>
        </div>

    </div>


    @if ($suppliers->isEmpty())


    <x-empty-state message="No suppliers found" />


    @else

    <x-table :headers="['#', 'Name', 'Contact', 'Status', 'Created At']" showActions="false">

        @foreach ($suppliers as $index => $supplier)
        <x-table.row>
            <x-table.cell>{{ $index + 1 }}</x-table.cell>
            <x-table.cell> {{ $supplier->name }} </x-table.cell>
            <x-table.cell> {{ $supplier->email }} </x-table.cell>
            <x-table.cell>
                <x-status-badge :status="$supplier->status" />

            </x-table.cell>
            <x-table.cell> {{ $supplier->created_at->format('M d, Y H:i A') }}</x-table.cell>
           <x-table.cell>
        <div class="flex space-x-2">

          <a class="btn" href="{{ route('suppliers.show', $supplier) }}" title="View">
            <i data-lucide="eye" class="w-4 h-4 "></i>
          </a>

          <a class="btn" href="{{ route('suppliers.edit', $supplier) }}" title="Edit">
            <i data-lucide="edit" class="w-4 h-4 "></i>
          </a>

          <x-confirm-modal :action="route('suppliers.destroy', $supplier->id)"
            warning="Are you sure you want to delete this supplier? This action cannot be undone."
            triggerIcon="trash" />

        </div>

      </x-table.cell>
        </x-table.row>

        @endforeach

    </x-table>


    @endif

</x-app-layout>