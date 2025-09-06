@props([
    'headers' => [],
    'showActions' => false,
])

<div class="bg-blue-50  border  border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full  text-sm">
            <!-- Table Head -->
            <thead class="bg-gray-100  text-black ">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs  font-bold border uppercase tracking-wider whitespace-nowrap w-auto min-w-max">



                            {{ $header }}
                        </th>
                    @endforeach

                    @if ($showActions)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class=" divide-y divide-gray-200 bg-white ">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
