






<x-app-layout>

  <x-page-title title="Customer Details" subtitle="Information about {{ $customer->name }}" />

  <div class="rounded-lg shadow p-6 space-y-6 mt-4 bg-white text-gray-900 transition-colors">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div>
        <h3 class="font-semibold text-gray-700">Name</h3>
        <p class="text-gray-900">{{ $customer->name }}</p>
      </div>

      <div>
        <h3 class="font-semibold text-gray-700">Email</h3>
        <p class="text-gray-900">{{ $customer->email ?? '—' }}</p>
      </div>

      <div>
        <h3 class="font-semibold text-gray-700">Phone</h3>
        <p class="text-gray-900">{{ $customer->phone ?? '—' }}</p>
      </div>

      <div class="md:col-span-2">
        <h3 class="font-semibold text-gray-700">Address</h3>
        <p class="text-gray-900">{{ $customer->address ?? '—' }}</p>
      </div>

    </div>

    <div class="flex justify-end space-x-3 mt-6">
      <a href="{{ route('customers.edit', $customer->id) }}" class="btn">
        Edit <i data-lucide="edit" class="w-4 h-4 ml-2"></i>
      </a>
      <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
        onsubmit="return confirm('Are you sure you want to delete this customer?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white">
          Delete <i data-lucide="trash" class="w-4 h-4 ml-2"></i>
        </button>
      </form>
    </div>

  </div>

</x-app-layout>