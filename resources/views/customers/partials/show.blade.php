<x-slide-form button-icon="eye" title="{{ $customer->name }}">
    <div class="customer-card">
        <div class="customer-details-section">
            <div class="profile-image-placeholder">


                <img src="{{ $customer->avatar ? asset('storage/' . $customer->avatar) : asset('default-avatar.png') }}"
                    alt="{{ $customer->name }}" class="w-full h-full">

            </div>
            <div class="customer-info-grid">
                <div class="info-item">
                    <span class="info-label">Name :</span>
                    <span class="info-value">{{ $customer->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email :</span>
                    <span class="info-value">{{ $customer->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone Number :</span>
                    <span class="info-value">{{ $customer->phone }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Billing Address :</span>
                    <span class="info-value">{{ $customer->address }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Tax Number :</span>
                    <span class="info-value">{{ $customer->tin_number }}</span>
                </div>
            </div>
        </div>
        <div class="transactions-section">
            <x-table :headers="['#', ]" showActions="false">
                <x-table.row>
                    <x-table.cell>1</x-table.cell>


                    <x-table.cell>
                        <x-dropdown-actions>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-green-600">View</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-blue-600">Edit</a>
                        </x-dropdown-actions>
                    </x-table.cell>
                </x-table.row>

            </x-table>
        </div>
    </div>
</x-slide-form>