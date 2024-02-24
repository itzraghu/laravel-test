<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-session-status class="mb-4" :status="session('success')" />
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form action="{{ route('coffee.sales.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="shipping_cost" value="{{ $shipping_cost }}">
                        <div class="flex mb-4">
                            <div class="w-1/5 h-12 px-2">
                                <label for="product"
                                    class="block text-sm font-medium leading-6 text-gray-900">{{ __('Product') }}</label>
                                <div class="mt-2">
                                    <select id="product" name="product_id" autocomplete="product"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6"
                                        onchange="calculateSellingPrice()">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-profit_margin="{{ $product->profit_margin_percent }}">
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/5 h-12 px-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                                    {{ __('Quantity') }}
                                </label>
                                <div class="mt-2">
                                    <input
                                        class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                        id="quantity" type="text" placeholder="1" name="quantity"
                                        onkeyup="calculateSellingPrice()">
                                </div>
                            </div>
                            <div class="w-1/5 h-12 px-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="unit_cost">
                                    {{ __('Unit Cost') }}
                                </label>
                                <div class="mt-2">
                                    <input
                                        class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                        id="unit_cost" type="text" placeholder="{{ __('Unit Cost') }}"
                                        name="unit_cost" onkeyup="calculateSellingPrice()">
                                </div>
                            </div>
                            <div class="w-1/5 h-12 px-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="unit_cost">
                                    {{ __('Selling Price') }}
                                </label>
                                <div class="mt-3" id="selling_price">
                                    £0
                                </div>
                            </div>
                            <div class="w-1/5 h-12 px-2">
                                <button
                                    class="mt-3 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">

                                    {{ __('Record Sale') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>{{ __('Previous Sales') }}</h2>
                    <div class="relative overflow-x-auto sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Product name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Quantity') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __(' Unit Cost') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Selling Price') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Sold at') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($previous_sales as $sale)
                                    <tr
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 text-center">
                                            {{ $sale->product->name }}
                                        </th>
                                        <td class="px-6 py-4 text-center ">
                                            {{ $sale->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-center ">
                                            {{ $sale->unit_cost }}
                                        </td>
                                        <td class="px-6 py-4 text-center ">
                                            £{{ $sale->selling_price }}
                                        </td>
                                        <td class="px-6 py-4 text-center ">
                                            {{ $sale->created_at }}
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center px-6 py-4">No sells found.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                        {{ $previous_sales->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateSellingPrice() {
            let profitMarginPercent = parseFloat(
                $("#product option:selected").data("profit_margin")
            );
            let quantity = $("#quantity").val();
            let unitCost = $("#unit_cost").val();

            let profitMargin = parseFloat(profitMarginPercent / 100);
            let shippingCost = parseFloat($("#shipping_cost").val());
            if (quantity !== "" && unitCost !== "") {
                let sellingPrice =
                    parseFloat(quantity * unitCost) / (1 - profitMargin) + shippingCost;

                $("#selling_price").text("£" + sellingPrice.toFixed(2));
            }
        }
    </script>
</x-app-layout>
