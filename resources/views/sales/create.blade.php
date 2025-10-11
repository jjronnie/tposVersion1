@extends('layouts.main')
@section('content')
    <div x-data="posSystem()" x-init="init()" class="h-screen flex flex-col bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('sales.index') }}" 
               class="inline-flex items-center text-sm text-gray-700 hover:text-blue-700 border border-gray-300 rounded px-3 py-1 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Point of Sale</h1>
        </div>

        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600" x-text="new Date().toLocaleString()"></span>
            <a href="{{ route('sales.index') }}" class="btn-sm">
                View Sales History
            </a>
        </div>
    </div>
</div>


        <div class="flex-1 flex overflow-hidden">
            <!-- Left Side - Product Selection -->
            <div class="flex-1 flex flex-col p-6 overflow-hidden">
                <!-- Search Bar -->
                <div class="mb-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            x-model="productSearch"
                            @input.debounce.300ms="searchProducts()"
                            @keydown.enter.prevent="selectFirstProduct()"
                            x-ref="productSearchInput"
                            placeholder="Search products by name, barcode, or SKU..."
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            autocomplete="off"
                        >
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <div x-show="searching" class="absolute right-3 top-3.5">
                            <svg class="animate-spin h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Product Search Results Dropdown -->
                    <div x-show="productSearch.length > 0 && searchResults.length > 0" 
                         x-transition
                         class="absolute z-50 mt-1 w-full max-w-2xl bg-white border border-gray-300 rounded-lg shadow-lg max-h-96 overflow-y-auto">
                        <template x-for="(product, index) in searchResults" :key="product.id">
                            <div @click="addProductToCart(product)"
                                 :class="{'bg-blue-50': index === 0}"
                                 class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900" x-text="product.name"></div>
                                        <div class="text-sm text-gray-500">
                                            <span x-text="'Stock: ' + product.quantity + ' ' + product.unit"></span>
                                            {{-- <span x-show="product.barcode" x-text="' • ' + product.barcode" class="ml-2"></span> --}}
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="font-semibold text-gray-900" x-text="formatCurrency(product.selling_price)"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- No Results -->
                    <div x-cloak x-show="productSearch.length > 0 && searchResults.length === 0 && !searching"
                         x-transition
                         class="absolute z-50 mt-1 w-full max-w-2xl bg-white border border-gray-300 rounded-lg shadow-lg p-4 text-center text-gray-500">
                        No products found
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 bg-white rounded-lg shadow overflow-hidden flex flex-col">
                    <div class="bg-gray-50 px-4 py-3 border-b">
                        <h2 class="font-semibold text-gray-700">Cart Items (<span x-text="cartItems.length"></span>)</h2>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto">
                        <template x-if="cartItems.length === 0">
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <p class="mt-2">Cart is empty</p>
                                    <p class="text-sm">Search and add products</p>
                                </div>
                            </div>
                        </template>

                        <x-table :headers="['Product', 'Price', 'Quantity', 'Subtotal', ]" showActions="false">
                            <template x-for="(item, index) in cartItems" :key="index">
                                <x-table.row>
                                    <x-table.cell>
                                        <div>
                                            <div class="font-medium text-gray-900" x-text="item.name"></div>
                                            <div class="text-xs text-gray-500" x-text="'Stock: ' + item.available_stock + ' ' + item.unit"></div>
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <input 
                                            type="number" 
                                            x-model.number="item.price"
                                            @input="calculateTotals()"
                                            step="0.01"
                                            min="0"
                                            class="w-24 px-2 py-1 border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                                        >
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center space-x-2">
                                            <button @click="decrementQuantity(index)" 
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded">
                                                <span class="text-lg font-bold">−</span>
                                            </button>
                                            <input 
                                                type="number" 
                                                x-model.number="item.quantity"
                                                @input="validateQuantity(index)"
                                                min="1"
                                                :max="item.available_stock"
                                                class="w-16 px-2 py-1 text-center border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                                            >
                                            <button @click="incrementQuantity(index)" 
                                                    :disabled="item.quantity >= item.available_stock"
                                                    :class="item.quantity >= item.available_stock ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300'"
                                                    class="w-8 h-8 flex items-center justify-center rounded">
                                                <span class="text-lg font-bold">+</span>
                                            </button>
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <span class="font-semibold text-gray-900" x-text="formatCurrency(item.price * item.quantity)"></span>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <button @click="removeFromCart(index)" 
                                                class="btn-danger">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </x-table.cell>
                                </x-table.row>
                            </template>
                        </x-table>
                    </div>
                </div>
            </div>

            <!-- Right Side - Customer & Payment -->
            <div class="w-96 bg-white border-l flex flex-col">
                <!-- Customer Selection -->
                <div class="p-4 border-b">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer (Optional)</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            x-model="customerSearch"
                            @input.debounce.300ms="searchCustomers()"
                            @focus="customerSearchFocused = true"
                            placeholder="Search customer..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            autocomplete="off"
                        >
                        
                        <div x-show="customerSearch.length > 0 && customerResults.length > 0 && customerSearchFocused"
                             @click.away="customerSearchFocused = false"
                             x-transition
                             x-cloak
                             class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                            <template x-for="customer in customerResults" :key="customer.id">
                                <div @click="selectCustomer(customer)"
                                     class="px-3 py-2 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                    <div class="font-medium text-gray-900" x-text="customer.name"></div>
                                    <div class="text-sm text-gray-500" x-text="customer.phone"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    <div x-show="selectedCustomer" class="mt-2 p-3 bg-blue-50 rounded-lg flex justify-between items-center">
                        <div>
                            <div class="font-medium text-gray-900" x-text="selectedCustomer?.name"></div>
                            <div class="text-sm text-gray-600" x-text="selectedCustomer?.phone"></div>
                        </div>
                        <button @click="clearCustomer()" class="text-red-600 hover:text-red-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Totals Summary -->
                <div class="flex-1 p-4 space-y-3 overflow-y-auto">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium" x-text="formatCurrency(totals.subtotal)"></span>
                        </div>
                        
                        <div class="flex justify-between text-sm items-center">
                            <span class="text-gray-600">Discount</span>
                            <input 
                                type="number" 
                                x-model.number="totals.discount"
                                @input="calculateTotals()"
                                step="0.01"
                                min="0"
                                :max="totals.subtotal"
                                class="w-24 px-2 py-1 text-right border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div class="flex justify-between text-sm items-center">
                            <span class="text-gray-600">Tax</span>
                            <input 
                                type="number" 
                                x-model.number="totals.tax"
                                @input="calculateTotals()"
                                step="0.01"
                                min="0"
                                class="w-24 px-2 py-1 text-right border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div class="border-t pt-2 flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-blue-600" x-text="formatCurrency(totals.grandTotal)"></span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="pt-3 border-t">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <select x-model="paymentMethod" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="transfer">Transfer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Amount Paid -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount Paid</label>
                        <input 
                            type="number" 
                            x-model.number="amountPaid"
                            @input="calculateChange()"
                            step="0.01"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-lg font-semibold"
                            placeholder="0.00"
                        >
                        <div class="mt-2 flex justify-between text-sm">
                            <span class="text-gray-600">Change</span>
                            <span :class="change >= 0 ? 'text-green-600' : 'text-red-600'" 
                                  class="font-semibold" 
                                  x-text="formatCurrency(Math.max(0, change))"></span>
                        </div>
                    </div>

                    <!-- Quick Amount Buttons -->
                    <div x-show="paymentMethod === 'cash'" class="grid grid-cols-3 gap-2">
                        <template x-for="amount in [1000, 2000, 5000, 10000, 20000, 50000]" :key="amount">
                            <button @click="amountPaid = amount; calculateChange()"
                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium">
                                <span x-text="formatCurrency(amount)"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea 
                            x-model="notes"
                            rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="Add notes..."></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 border-t space-y-2">
                    <button @click="completeSale()" 
                            :disabled="cartItems.length === 0 || processing"
                            :class="cartItems.length === 0 || processing ? 'bg-gray-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                            class="w-full py-3 px-4 text-white rounded-lg font-semibold transition-colors">
                        <span x-show="!processing">Complete Sale</span>
                        <span x-show="processing">Processing...</span>
                    </button>
                    
                    <button @click="clearCart()" 
                            :disabled="cartItems.length === 0"
                            :class="cartItems.length === 0 ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300'"
                            class="w-full py-2 px-4 text-gray-700 rounded-lg font-medium transition-colors">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div x-show="showSuccessModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black opacity-50" @click="closeSuccessModal()"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Sale Completed!</h3>
                        <p class="text-sm text-gray-600 mb-1">Invoice: <span class="font-mono" x-text="lastSale?.invoice_number"></span></p>
                        <p class="text-2xl font-bold text-green-600 mb-4" x-show="lastSale?.change > 0">
                            Change: <span x-text="formatCurrency(lastSale?.change)"></span>
                        </p>
                        <div class="space-y-2">
                            <button @click="printReceipt()" 
                                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                                Print Receipt
                            </button>
                            <button @click="closeSuccessModal()" 
                                    class="w-full py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium">
                                New Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Toast -->
        <div x-show="errorMessage" 
             x-transition
             class="fixed bottom-4 left-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg max-w-md z-50"
             style="display: none;">
            <div class="flex items-center justify-between">
                <span x-text="errorMessage"></span>
                <button @click="errorMessage = ''" class="ml-4 text-red-700 hover:text-red-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                // Search & Results
                productSearch: '',
                customerSearch: '',
                searchResults: [],
                customerResults: [],
                searching: false,
                customerSearchFocused: false,

                // Cart
                cartItems: [],
                selectedCustomer: null,

                // Totals
                totals: {
                    subtotal: 0,
                    discount: 0,
                    tax: 0,
                    grandTotal: 0
                },

                // Payment
                paymentMethod: 'cash',
                amountPaid: 0,
                change: 0,
                notes: '',

                // UI State
                processing: false,
                showSuccessModal: false,
                errorMessage: '',
                lastSale: null,

                init() {
                    this.$refs.productSearchInput.focus();
                    
                    // Listen for barcode scanner input
                    let barcodeBuffer = '';
                    let barcodeTimeout = null;
                    
                    document.addEventListener('keypress', (e) => {
                        // If not focused on an input and key is pressed quickly (scanner behavior)
                        if (document.activeElement.tagName !== 'INPUT' && 
                            document.activeElement.tagName !== 'TEXTAREA') {
                            
                            clearTimeout(barcodeTimeout);
                            barcodeBuffer += e.key;
                            
                            barcodeTimeout = setTimeout(() => {
                                if (barcodeBuffer.length > 3) {
                                    this.productSearch = barcodeBuffer;
                                    this.searchProducts();
                                }
                                barcodeBuffer = '';
                            }, 100);
                        }
                    });

                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        // F2 - Focus product search
                        if (e.key === 'F2') {
                            e.preventDefault();
                            this.$refs.productSearchInput.focus();
                        }
                        // F9 - Complete sale
                        if (e.key === 'F9' && this.cartItems.length > 0 && !this.processing) {
                            e.preventDefault();
                            this.completeSale();
                        }
                        // ESC - Clear product search or close modals
                        if (e.key === 'Escape') {
                            if (this.showSuccessModal) {
                                this.closeSuccessModal();
                            } else {
                                this.productSearch = '';
                                this.searchResults = [];
                            }
                        }
                    });
                },

                async searchProducts() {
                    if (this.productSearch.length < 1) {
                        this.searchResults = [];
                        return;
                    }

                    this.searching = true;
                    
                    try {
                        const response = await fetch(`/sales/search-products?search=${encodeURIComponent(this.productSearch)}`);
                        const data = await response.json();
                        this.searchResults = data;
                    } catch (error) {
                        console.error('Product search failed:', error);
                        this.showError('Failed to search products');
                    } finally {
                        this.searching = false;
                    }
                },

                async searchCustomers() {
                    if (this.customerSearch.length < 2) {
                        this.customerResults = [];
                        return;
                    }

                    try {
                        const response = await fetch(`/sales/search-customers?search=${encodeURIComponent(this.customerSearch)}`);
                        const data = await response.json();
                        this.customerResults = data;
                    } catch (error) {
                        console.error('Customer search failed:', error);
                    }
                },

                selectFirstProduct() {
                    if (this.searchResults.length > 0) {
                        this.addProductToCart(this.searchResults[0]);
                    }
                },

                addProductToCart(product) {
                    // Check if product already in cart
                    const existingIndex = this.cartItems.findIndex(item => item.product_id === product.id);
                    
                    if (existingIndex !== -1) {
                        // Increment quantity if not exceeding stock
                        if (this.cartItems[existingIndex].quantity < product.quantity) {
                            this.cartItems[existingIndex].quantity++;
                        } else {
                            this.showError(`Maximum stock available: ${product.quantity}`);
                        }
                    } else {
                        // Add new item to cart
                        this.cartItems.push({
                            product_id: product.id,
                            name: product.name,
                            price: parseFloat(product.selling_price),
                            quantity: 1,
                            unit: product.unit,
                            available_stock: product.quantity
                        });
                    }

                    // Clear search
                    this.productSearch = '';
                    this.searchResults = [];
                    
                    // Recalculate totals
                    this.calculateTotals();
                    
                    // Focus back on search
                    this.$nextTick(() => {
                        this.$refs.productSearchInput.focus();
                    });
                },

                removeFromCart(index) {
                    this.cartItems.splice(index, 1);
                    this.calculateTotals();
                },

                incrementQuantity(index) {
                    const item = this.cartItems[index];
                    if (item.quantity < item.available_stock) {
                        item.quantity++;
                        this.calculateTotals();
                    } else {
                        this.showError(`Maximum stock available: ${item.available_stock}`);
                    }
                },

                decrementQuantity(index) {
                    const item = this.cartItems[index];
                    if (item.quantity > 1) {
                        item.quantity--;
                        this.calculateTotals();
                    }
                },

                validateQuantity(index) {
                    const item = this.cartItems[index];
                    
                    if (item.quantity < 1) {
                        item.quantity = 1;
                    } else if (item.quantity > item.available_stock) {
                        item.quantity = item.available_stock;
                        this.showError(`Maximum stock available: ${item.available_stock}`);
                    }
                    
                    this.calculateTotals();
                },

                calculateTotals() {
                    this.totals.subtotal = this.cartItems.reduce((sum, item) => {
                        return sum + (item.price * item.quantity);
                    }, 0);

                    // Ensure discount doesn't exceed subtotal
                    if (this.totals.discount > this.totals.subtotal) {
                        this.totals.discount = this.totals.subtotal;
                    }

                    this.totals.grandTotal = this.totals.subtotal - this.totals.discount + this.totals.tax;
                    
                    this.calculateChange();
                },

                calculateChange() {
                    this.change = this.amountPaid - this.totals.grandTotal;
                },

                selectCustomer(customer) {
                    this.selectedCustomer = customer;
                    this.customerSearch = customer.name;
                    this.customerSearchFocused = false;
                },

                clearCustomer() {
                    this.selectedCustomer = null;
                    this.customerSearch = '';
                },

                clearCart() {
                    if (confirm('Are you sure you want to clear the cart?')) {
                        this.cartItems = [];
                        this.totals = { subtotal: 0, discount: 0, tax: 0, grandTotal: 0 };
                        this.amountPaid = 0;
                        this.change = 0;
                        this.notes = '';
                        this.clearCustomer();
                        this.$refs.productSearchInput.focus();
                    }
                },

                async completeSale() {
                    if (this.cartItems.length === 0) {
                        this.showError('Cart is empty');
                        return;
                    }

                    if (this.amountPaid < this.totals.grandTotal) {
                        if (!confirm('Amount paid is less than total. Continue with partial payment?')) {
                            return;
                        }
                    }

                    this.processing = true;

                    const saleData = {
                        customer_id: this.selectedCustomer?.id || null,
                        sale_date: new Date().toISOString().split('T')[0],
                        payment_method: this.paymentMethod,
                        amount_paid: this.amountPaid,
                        notes: this.notes,
                        items: this.cartItems.map(item => ({
                            product_id: item.product_id,
                            quantity: item.quantity,
                            price: item.price
                        })),
                        grand_total: this.totals.grandTotal,
                        discount_amount: this.totals.discount,
                        tax_amount: this.totals.tax,
                        _token: '{{ csrf_token() }}'
                    };

                    try {
                        const response = await fetch('{{ route("sales.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(saleData)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            this.lastSale = result;
                            this.showSuccessModal = true;
                            
                            // Reset form for next sale
                            this.cartItems = [];
                            this.totals = { subtotal: 0, discount: 0, tax: 0, grandTotal: 0 };
                            this.amountPaid = 0;
                            this.change = 0;
                            this.notes = '';
                            this.clearCustomer();
                        } else {
                            this.showError(result.message || 'Failed to complete sale');
                        }
                    } catch (error) {
                        console.error('Sale failed:', error);
                        this.showError('Network error. Please check your connection.');
                    } finally {
                        this.processing = false;
                    }
                },

                closeSuccessModal() {
                    this.showSuccessModal = false;
                    this.lastSale = null;
                    this.$nextTick(() => {
                        this.$refs.productSearchInput.focus();
                    });
                },

                printReceipt() {
                    if (this.lastSale?.sale_id) {
                        window.open(`/sales/${this.lastSale.sale_id}/print`, '_blank');
                    }
                    this.closeSuccessModal();
                },

                showError(message) {
                    this.errorMessage = message;
                    setTimeout(() => {
                        this.errorMessage = '';
                    }, 5000);
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('en-UG', {
                        style: 'currency',
                        currency: 'UGX',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(amount || 0);
                }
            }
        }
    </script>
@endsection