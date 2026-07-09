@extends('admin.catalog.layouts.app')

@section('title', 'Create Order')

@section('content')

    <form method="POST" action="{{ route('admin.sales.orders.store') }}" id="orderForm">
        @csrf

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold">Create Order</h1>
                <p class="text-black/45 text-sm mt-1">Manually record a new customer order.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.sales.orders.index') }}" class="inline-flex items-center gap-2 bg-white border border-black/10 rounded-full px-4 py-2.5 text-xs font-semibold hover:bg-black/[0.03] transition">
                    <i class="fa-solid fa-arrow-left text-black/40 text-[10px]"></i> Back
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-primary text-ink rounded-full px-5 py-2.5 text-xs font-semibold hover:bg-primary-dark transition">
                    <i class="fa-solid fa-check text-[10px]"></i> Create Order
                </button>
            </div>
        </div>

        <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">
            <div class="space-y-6 min-w-0">

                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <h2 class="font-bold text-sm mb-1">Customer</h2>
                    <p class="text-black/40 text-xs mb-5">Pick an existing customer or enter details manually.</p>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5" for="customerSelect">Existing Customer (optional)</label>
                            <select id="customerSelect" class="w-full appearance-none px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                                <option value="">— Guest / manual entry —</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" data-name="{{ trim($customer->first_name.' '.$customer->last_name) }}" data-email="{{ $customer->email }}" data-phone="{{ $customer->phone }}">{{ trim($customer->first_name.' '.$customer->last_name) ?: $customer->email }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="user_id" id="userIdField">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="customerName">Customer Name</label>
                            <input id="customerName" name="customer_name" type="text" required value="{{ old('customer_name') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="customerEmail">Email</label>
                            <input id="customerEmail" name="customer_email" type="email" required value="{{ old('customer_email') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="customerPhone">Phone</label>
                            <input id="customerPhone" name="customer_phone" type="text" value="{{ old('customer_phone') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <div class="flex items-center justify-between gap-4 mb-1">
                        <h2 class="font-bold text-sm">Order Items</h2>
                        <button type="button" id="addItemBtn" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-dark hover:text-ink transition">
                            <i class="fa-solid fa-plus text-[10px]"></i> Add Item
                        </button>
                    </div>
                    <p class="text-black/40 text-xs mb-5">Pick products and quantities for this order.</p>

                    <div id="itemsContainer" class="space-y-3"></div>
                    <p id="noItemsMsg" class="text-black/35 text-xs text-center py-4">No items added yet.</p>
                    <input type="hidden" name="items_json" id="itemsJson">

                    <div class="flex justify-end mt-4 pt-4 border-t border-black/5">
                        <p class="text-sm font-semibold">Subtotal: <span id="subtotalDisplay">$0.00</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <h2 class="font-bold text-sm mb-1">Shipping Address</h2>
                    <div class="grid sm:grid-cols-2 gap-5 mt-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5" for="shipName">Full Name</label>
                            <input id="shipName" name="shipping_name" type="text" required value="{{ old('shipping_name') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5" for="shipAddr1">Address Line 1</label>
                            <input id="shipAddr1" name="shipping_address_line1" type="text" required value="{{ old('shipping_address_line1') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5" for="shipAddr2">Address Line 2</label>
                            <input id="shipAddr2" name="shipping_address_line2" type="text" value="{{ old('shipping_address_line2') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="shipCity">City</label>
                            <input id="shipCity" name="shipping_city" type="text" required value="{{ old('shipping_city') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="shipState">State</label>
                            <input id="shipState" name="shipping_state" type="text" value="{{ old('shipping_state') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="shipZip">Postal Code</label>
                            <input id="shipZip" name="shipping_zip" type="text" value="{{ old('shipping_zip') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="shipCountry">Country</label>
                            <input id="shipCountry" name="shipping_country" type="text" required value="{{ old('shipping_country', 'Pakistan') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="shipPhone">Phone</label>
                            <input id="shipPhone" name="shipping_phone" type="text" value="{{ old('shipping_phone') }}" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm font-medium mt-5">
                        <input type="checkbox" id="billingSameCheckbox" name="billing_same_as_shipping" value="1" checked class="rounded"> Billing address same as shipping
                    </label>

                    <div id="billingFields" class="hidden grid sm:grid-cols-2 gap-5 mt-4 pt-4 border-t border-black/5">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5" for="billName">Full Name</label>
                            <input id="billName" name="billing_name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5" for="billAddr1">Address Line 1</label>
                            <input id="billAddr1" name="billing_address_line1" type="text" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="billCity">City</label>
                            <input id="billCity" name="billing_city" type="text" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="billState">State</label>
                            <input id="billState" name="billing_state" type="text" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="billZip">Postal Code</label>
                            <input id="billZip" name="billing_zip" type="text" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="billCountry">Country</label>
                            <input id="billCountry" name="billing_country" type="text" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <label class="block text-sm font-medium mb-1.5" for="customerNote">Customer Note</label>
                    <textarea id="customerNote" name="customer_note" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition resize-none">{{ old('customer_note') }}</textarea>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-card p-5 md:p-6">
                    <h2 class="font-bold text-sm mb-4">Totals</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="shippingAmount">Shipping</label>
                            <input id="shippingAmount" name="shipping_amount" type="number" step="0.01" min="0" value="0" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="discountAmount">Discount</label>
                            <input id="discountAmount" name="discount_amount" type="number" step="0.01" min="0" value="0" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" for="taxAmount">Tax</label>
                            <input id="taxAmount" name="tax_amount" type="number" step="0.01" min="0" value="0" class="w-full px-4 py-2.5 rounded-xl border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary transition">
                        </div>
                        <div class="pt-3 border-t border-black/5 flex justify-between text-base font-bold">
                            <span>Total</span><span id="totalDisplay">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script>
  @php $productsPayload = $products; @endphp
  const products = @json($productsPayload);

  // ---- customer autofill ----
  const customerSelect = document.getElementById('customerSelect');
  customerSelect.addEventListener('change', () => {
    const opt = customerSelect.selectedOptions[0];
    document.getElementById('userIdField').value = customerSelect.value;
    if (customerSelect.value) {
      document.getElementById('customerName').value = opt.dataset.name || '';
      document.getElementById('customerEmail').value = opt.dataset.email || '';
      document.getElementById('customerPhone').value = opt.dataset.phone || '';
    }
  });

  // ---- billing toggle ----
  const billingSameCheckbox = document.getElementById('billingSameCheckbox');
  const billingFields = document.getElementById('billingFields');
  billingSameCheckbox.addEventListener('change', () => {
    billingFields.classList.toggle('hidden', billingSameCheckbox.checked);
  });

  // ---- line items ----
  const itemsContainer = document.getElementById('itemsContainer');
  const noItemsMsg = document.getElementById('noItemsMsg');
  const itemsJsonInput = document.getElementById('itemsJson');
  const subtotalDisplay = document.getElementById('subtotalDisplay');
  const totalDisplay = document.getElementById('totalDisplay');
  let items = [];
  let itemSeq = 0;

  function addItem() {
    items.push({ key: ++itemSeq, product_id: '', variant_id: '', product_name: '', variant_label: '', sku: '', unit_price: 0, weight: 0, quantity: 1 });
    renderItems();
  }

  function renderItems() {
    itemsContainer.innerHTML = '';
    noItemsMsg.classList.toggle('hidden', items.length > 0);

    items.forEach((item) => {
      const row = document.createElement('div');
      row.className = 'flex flex-wrap items-center gap-2 border border-black/10 rounded-xl p-3';

      const productSelect = document.createElement('select');
      productSelect.className = 'flex-1 min-w-[160px] px-3 py-2 rounded-lg border border-black/10 text-sm';
      productSelect.innerHTML = '<option value="">Select product...</option>' +
        products.map(p => `<option value="${p.id}">${p.name}${p.sku ? ' (' + p.sku + ')' : ''}</option>`).join('');
      productSelect.value = item.product_id;

      const variantSelect = document.createElement('select');
      variantSelect.className = 'w-40 px-3 py-2 rounded-lg border border-black/10 text-sm' + (item.variantOptions?.length ? '' : ' hidden');

      const qtyInput = document.createElement('input');
      qtyInput.type = 'number';
      qtyInput.min = '1';
      qtyInput.value = item.quantity;
      qtyInput.className = 'w-20 px-3 py-2 rounded-lg border border-black/10 text-sm';

      const priceLabel = document.createElement('span');
      priceLabel.className = 'w-24 text-right text-sm font-semibold';
      priceLabel.textContent = '$' + (item.unit_price * item.quantity).toFixed(2);

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.className = 'w-8 h-8 rounded-full grid place-items-center text-black/30 hover:text-danger transition';
      removeBtn.innerHTML = '<i class="fa-solid fa-trash-can text-xs"></i>';
      removeBtn.addEventListener('click', () => { items = items.filter(i => i.key !== item.key); renderItems(); });

      function populateVariants() {
        const product = products.find(p => String(p.id) === String(item.product_id));
        const variants = product?.variants || [];
        if (variants.length) {
          variantSelect.classList.remove('hidden');
          variantSelect.innerHTML = '<option value="">No variant</option>' + variants.map(v => `<option value="${v.id}">${v.label}</option>`).join('');
          variantSelect.value = item.variant_id || '';
        } else {
          variantSelect.classList.add('hidden');
          variantSelect.innerHTML = '';
        }
      }

      productSelect.addEventListener('change', () => {
        item.product_id = productSelect.value;
        const product = products.find(p => String(p.id) === String(item.product_id));
        item.product_name = product?.name || '';
        item.sku = product?.sku || '';
        item.unit_price = product?.price || 0;
        item.weight = product?.weight || 0;
        item.variant_id = '';
        item.variant_label = '';
        populateVariants();
        renderItems();
      });

      variantSelect.addEventListener('change', () => {
        item.variant_id = variantSelect.value;
        const product = products.find(p => String(p.id) === String(item.product_id));
        const variant = product?.variants.find(v => String(v.id) === String(item.variant_id));
        item.variant_label = variant?.label || '';
        item.unit_price = variant ? variant.price : (product?.price || 0);
        renderItems();
      });

      qtyInput.addEventListener('input', () => {
        item.quantity = parseInt(qtyInput.value, 10) || 1;
        updateTotals();
        priceLabel.textContent = '$' + (item.unit_price * item.quantity).toFixed(2);
        syncItemsJson();
      });

      row.appendChild(productSelect);
      row.appendChild(variantSelect);
      row.appendChild(qtyInput);
      row.appendChild(priceLabel);
      row.appendChild(removeBtn);
      itemsContainer.appendChild(row);

      populateVariants();
    });

    updateTotals();
    syncItemsJson();
  }

  function updateTotals() {
    const subtotal = items.reduce((sum, i) => sum + (i.unit_price * i.quantity), 0);
    const shipping = parseFloat(document.getElementById('shippingAmount').value) || 0;
    const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
    const tax = parseFloat(document.getElementById('taxAmount').value) || 0;
    subtotalDisplay.textContent = '$' + subtotal.toFixed(2);
    totalDisplay.textContent = '$' + (subtotal + shipping + tax - discount).toFixed(2);
  }

  function syncItemsJson() {
    itemsJsonInput.value = JSON.stringify(items.map(i => ({
      product_id: i.product_id || null,
      variant_id: i.variant_id || null,
      product_name: i.product_name,
      variant_label: i.variant_label || null,
      sku: i.sku || null,
      unit_price: i.unit_price,
      weight: i.weight || null,
      quantity: i.quantity,
    })));
  }

  ['shippingAmount', 'discountAmount', 'taxAmount'].forEach(id => {
    document.getElementById(id).addEventListener('input', updateTotals);
  });

  document.getElementById('addItemBtn').addEventListener('click', addItem);
  document.getElementById('orderForm').addEventListener('submit', (e) => {
    if (!items.length) {
      e.preventDefault();
      alert('Add at least one order item.');
    }
  });

  addItem();
</script>
@endpush
