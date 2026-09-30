<div class="row mb-3">
    <div class="col-md-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-control" required>
            <option value="">Select Supplier</option>
            @foreach($suppliers as $c)
                <option value="{{ $c->id }}" {{ old('supplier_id', $purchaseInvoice->supplier_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Invoice Number</label>
        <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number', $purchaseInvoice->invoice_number ?? '') }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Invoice Date</label>
        <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date', $purchaseInvoice->invoice_date ?? '') }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $purchaseInvoice->due_date ?? '') }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="Pending" {{ old('status', $purchaseInvoice->status ?? 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Paid" {{ old('status', $purchaseInvoice->status ?? '') == 'Paid' ? 'selected' : '' }}>Paid</option>
            <option value="Overdue" {{ old('status', $purchaseInvoice->status ?? '') == 'Overdue' ? 'selected' : '' }}>Overdue</option>
        </select>
    </div>
</div>
<h4>Items</h4>
<div class="table-responsive mb-3">
    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Tax Rate (%)</th>
                <th>Line Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="items-body">
            <!-- Dynamic rows -->
        </tbody>
    </table>
    <button type="button" class="btn btn-sm btn-info" id="add-item">Add Item</button>
</div>
<div class="row mb-3">
    <div class="col-md-8">
        <label>Notes</label>
        <textarea name="notes" class="form-control">{{ old('notes', $purchaseInvoice->notes ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <table class="table table-bordered">
            <tr><th>Subtotal</th><td id="t-subtotal">0.00</td></tr>
            <tr><th>Discount</th><td id="t-discount">0.00</td></tr>
            <tr><th>Tax</th><td id="t-tax">0.00</td></tr>
            <tr><th>Grand Total</th><td id="t-total">0.00</td></tr>
        </table>
    </div>
</div>

<template id="item-template">
    <tr>
        <td>
            <select name="items[{INDEX}][product_id]" class="form-control product-select" required>
                <option value="">Select</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" data-price="{{ $p->price }}" data-tax="{{ $p->tax_rate }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="items[{INDEX}][quantity]" class="form-control calc-input qty" value="1" min="0.01" step="0.01" required></td>
        <td><input type="number" name="items[{INDEX}][unit_price]" class="form-control calc-input price" value="0" min="0" step="0.01" required></td>
        <td><input type="number" name="items[{INDEX}][discount]" class="form-control calc-input discount" value="0" min="0" step="0.01"></td>
        <td><input type="number" name="items[{INDEX}][tax_rate]" class="form-control calc-input tax" value="0" min="0" step="0.01" required></td>
        <td><span class="line-total">0.00</span></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
    </tr>
</template>

@push('scripts')
<script>
    let itemIndex = 0;
    
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;
        
        document.querySelectorAll('#items-body tr').forEach(row => {
            let qty = parseFloat(row.querySelector('.qty').value) || 0;
            let price = parseFloat(row.querySelector('.price').value) || 0;
            let discount = parseFloat(row.querySelector('.discount').value) || 0;
            let taxRate = parseFloat(row.querySelector('.tax').value) || 0;
            
            let itemSubtotal = qty * price;
            let taxable = Math.max(0, itemSubtotal - discount);
            let tax = taxable * (taxRate / 100);
            let total = taxable + tax;
            
            row.querySelector('.line-total').textContent = total.toFixed(2);
            
            subtotal += itemSubtotal;
            totalDiscount += discount;
            totalTax += tax;
        });
        
        let grandTotal = subtotal - totalDiscount + totalTax;
        
        document.getElementById('t-subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('t-discount').textContent = totalDiscount.toFixed(2);
        document.getElementById('t-tax').textContent = totalTax.toFixed(2);
        document.getElementById('t-total').textContent = grandTotal.toFixed(2);
    }
    
    function attachEvents(row) {
        row.querySelectorAll('.calc-input').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
        row.querySelector('.product-select').addEventListener('change', function() {
            let option = this.options[this.selectedIndex];
            if(option.value) {
                row.querySelector('.price').value = option.dataset.price;
                row.querySelector('.tax').value = option.dataset.tax;
                calculateTotals();
            }
        });
        row.querySelector('.remove-item').addEventListener('click', function() {
            row.remove();
            calculateTotals();
        });
    }

    document.getElementById('add-item').addEventListener('click', function() {
        let template = document.getElementById('item-template').innerHTML;
        let html = template.replace(/{INDEX}/g, itemIndex++);
        document.getElementById('items-body').insertAdjacentHTML('beforeend', html);
        attachEvents(document.getElementById('items-body').lastElementChild);
    });

    // Pre-fill existing items (for edit view or validation errors)
    let existingItems = @json(old('items', isset($purchaseInvoice) ? $purchaseInvoice->purchaseInvoiceItems : []));
    if (existingItems && (Array.isArray(existingItems) || typeof existingItems === 'object')) {
        let itemsArray = Array.isArray(existingItems) ? existingItems : Object.values(existingItems);
        itemsArray.forEach(item => {
            let template = document.getElementById('item-template').innerHTML;
            let html = template.replace(/{INDEX}/g, itemIndex++);
            document.getElementById('items-body').insertAdjacentHTML('beforeend', html);
            let row = document.getElementById('items-body').lastElementChild;
            
            row.querySelector('.product-select').value = item.product_id || '';
            row.querySelector('.qty').value = item.quantity || '1';
            row.querySelector('.price').value = item.unit_price || '0';
            row.querySelector('.discount').value = item.discount || '0';
            row.querySelector('.tax').value = item.tax_rate || '0';
            
            attachEvents(row);
        });
        calculateTotals();
    }
</script>
@endpush