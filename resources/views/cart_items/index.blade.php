@extends('products.index.layouts.master')

@section('title', '購物車')

@section('content')
    <hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h1 class="text-2xl mb-4" align="center">購物車內容</h1>

            @if ($cartItems->count() > 0)
                    <table class="min-w-full bg-white border border-gray-200 mx-auto">
                        <tbody>
                        @foreach ($cartItems as $cartItem)
                            <tr>
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" style="transform: scale(1.5)" name="selected_items[]" checked value="{{ $cartItem->id }}">
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <img src="{{ asset('storage/products/' . $cartItem->product->image_url) }}" alt="{{ $cartItem->product->name }}" width="150px" height="150px">
                                </td>
                                <td class="py-2 px-4 border-b">{{ $cartItem->product->name }}</td>
                                <td class="py-2 px-4 border-b price" data-price="{{ $cartItem->product->price }}">
                                    ${{ $cartItem->product->price }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('cart_items.update', $cartItem->id) }}" method="POST" id="updateCartItemForm">
                                        @csrf
                                        @method('PATCH')
                                        <span class="quantity-span">
                                    <button class="quantity-minus" type="submit" onclick="setOperationInput('minus')">-</button>
                                    <input class="quantity-input" type="number"  name="quantity" value="{{ $cartItem->quantity }}" style="max-width: 6rem">
                                    <button class="quantity-plus" type="submit" onclick="setOperationInput('plus')">+</button>
                                    <input type="hidden" name="operation" id="operationInput" value="">
                                    </span>
                                    </form>
                                </td>
                                <td class="py-2 px-4 border-b subtotal">
                                    ${{ number_format($cartItem->quantity * $cartItem->product->price, 0) }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form id="deleteForm{{ $cartItem->id }}" action="{{ route('cart_items.destroy', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $cartItem->product->name }}', {{ $cartItem->id }})">刪除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                <form action="{{ route('orders.create') }}" method="GET" id="checkoutForm" onsubmit="return prepareCheckout(event)">
                    @csrf
                    @method('GET')
                    <input type="hidden" name="selected_items" id="selectedItemsInput" value="">
                    <div class="text-center">
                        <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">結帳</button>
                    </div>
                </form>

            @else
                <p class="text-gray-600">購物車內無商品。</p>
            @endif
        </div>
    </div>


    <script>
        function confirmDelete(name, Id) {
            if (confirm("確定要刪除 " + name + " 嗎？")) {
                document.getElementById('deleteForm' + Id).submit();
            }
        }

        function prepareCheckout(event) {
            event.preventDefault();  // 防止表單直接提交

            const selectedItems = getSelectedItems();
            const checkoutForm = document.getElementById('checkoutForm');
            const selectedItemsInput = document.getElementById('selectedItemsInput');

            // 將選擇的商品ID添加到結帳表單的 input value 中
            selectedItemsInput.value = selectedItems.join(',');

            // 將選擇的商品ID添加到結帳表單的 query string 中
            const queryString = selectedItems.length > 0 ? `?selected_items=${selectedItems.join(',')}` : '';
            checkoutForm.action = "{{ route('orders.create') }}" + queryString;

            // 如果有選擇的商品，觸發表單提交
            if (selectedItems.length > 0) {
                checkoutForm.submit();
            } else {
                // 如果沒有選擇商品，取消表單提交
                alert("請勾選至少一個商品進行結帳。");
            }
        }


        function getSelectedItems() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            const selectedItems = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedItems.push(checkbox.value);
                }
            });

            return selectedItems;
        }

        function setOperationInput(operation) {
            const operationInput = document.getElementById('operationInput');
            operationInput.value = operation;
            document.getElementById('updateCartItemForm').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const quantitySpans = document.querySelectorAll('.quantity-span');
            const totalAmountElement = document.getElementById('totalAmount');

            quantitySpans.forEach(span => {
                const quantityInput = span.querySelector('.quantity-input');
                const minusButton = span.querySelector('.quantity-minus');
                const plusButton = span.querySelector('.quantity-plus');

                minusButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    updateQuantity(quantityInput, -1);
                });

                plusButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    updateQuantity(quantityInput, 1);
                });
            });

            function updateQuantity(input, change) {
                let newValue = parseInt(input.value) + change;
                if (newValue < 1) {
                    newValue = 1;
                }
                input.value = newValue;

                const priceElement = input.closest('tr').querySelector('.price');
                const subtotalElement = input.closest('tr').querySelector('.subtotal');
                const productPrice = parseFloat(priceElement.dataset.price);
                const subtotal = newValue * productPrice;

                subtotalElement.textContent = `$${subtotal.toFixed(0)}`;
                updateTotalAmount();
            }

            function updateTotalAmount() {
                const subtotalElements = document.querySelectorAll('.subtotal');
                let totalAmount = 0;
                let totalShippingFee = parseFloat(document.getElementById('totalShippingFee').textContent.replace('$', ''));

                subtotalElements.forEach(subtotalElement => {
                    const checkbox = subtotalElement.closest('tr').querySelector('input[name="selected_items[]"]');
                    if (checkbox.checked) {
                        totalAmount += parseFloat(subtotalElement.textContent.replace('$', ''));
                    }
                });

                totalAmount += totalShippingFee;

                totalAmountElement.textContent = `$${totalAmount.toFixed(0)}`;
            }

        });
    </script>
@endsection


