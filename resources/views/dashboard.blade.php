<x-app-layout>

       <!-- Page title -->
     <div class="space-y-2">
         <h1 class="text-2xl md:text-2xl font-bold text-gray-900 pb-4 m-0">Dashboard</h1>
      
     </div>

     <section class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
    <!-- Left: Icon + Text -->
    <div class="flex items-start md:items-center gap-3">
    
         <i data-lucide="crown" class="w-6 h-6 text-yellow-500"></i>

        <div>
            <h3 class="text-sm font-semibold text-gray-800">Trial Plan</h3>
            <p class="text-sm text-gray-600">
                You are on trial version! Your trial ends on 
                <span class="font-medium text-gray-900">17-06-2026</span>
            </p>
        </div>
    </div>

    <!-- Right: Button -->
    <div>
        <a href="#"
           class="btn">
            Change Plan
      <i data-lucide="chevrons-right" class="w-5 h-5 ml-2 text-white"></i>
        </a>
    </div>
</section>



    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
    <!-- card -->
 <x-stat-card title="Total Sales" value="5,002,000" icon="shopping-cart" />
<x-stat-card title="Total Expenses" value="178,000" icon="receipt" />
<x-stat-card title="Payment Sent" value="125000" icon="arrow-up-circle" />
<x-stat-card title="Payment Received" value="4,300,009" icon="arrow-down-circle" />

    

</div>

</x-app-layout>
