<x-app-layout>

    <x-page-title title="Subscription Plans" />


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

      <a class="btn" href="{{ route('subscriptionPlans.create') }}"> <i data-lucide="plus" class="w-4 h-4 "></i></a>

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


    <x-table :headers="['#','Name','Active Subs','monthly cost', 'annual cost', 'max users', 'max products', 'Active']"
        showActions="false">
        @foreach ($plans as $index => $plan)


        <x-table.row>
            <x-table.cell>{{ $index +1 }}</x-table.cell>
            <x-table.cell>{{$plan->name }}</x-table.cell>
            <x-table.cell> {{ $plan->active_subscriptions_count }}</x-table.cell>
            <x-table.cell>${{ $plan->monthly_cost }}</x-table.cell>
            <x-table.cell>${{ $plan->annual_cost }}</x-table.cell>
            <x-table.cell>{{ $plan->max_users }}</x-table.cell>
            <x-table.cell>{{ $plan->max_products }}</x-table.cell>
            <x-table.cell>
                   @if($plan->is_active)
                                <span class="text-green-600 font-medium">Yes</span>
                            @else
                                <span class="text-gray-600">No</span>
                            @endif
            </x-table.cell>
            <x-table.cell>
                <a href="#" class="btn"><i data-lucide="eye" class="w-4 h-4 "></i></a>
                <a href="#" class="btn"><i data-lucide="pencil" class="w-4 h-4 "></i></a>
            </x-table.cell>
        </x-table.row>
        @endforeach
    </x-table>


</x-app-layout>