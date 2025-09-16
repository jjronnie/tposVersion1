@props([
    'headers' => [],
    'showActions' => false,
])

<div class="bg-blue-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <!-- Table Head -->
            <thead class="bg-gray-100 dark:bg-gray-800 text-black dark:text-gray-100">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold border-b border-gray-200 dark:border-gray-700 uppercase tracking-wider whitespace-nowrap w-auto min-w-max">
                            {{ $header }}
                        </th>
                    @endforeach

                    @if ($showActions)
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium border-b border-gray-200 dark:border-gray-700 uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
