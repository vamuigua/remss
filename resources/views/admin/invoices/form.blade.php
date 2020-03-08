<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Invoice No.</label>
            <input type="text" class="form-control" v-model="form.invoice_no">
            <p v-if="errors.invoice_no" class="error">@{{errors.invoice_no[0]}}</p>
        </div>
        <div class="form-group">
            <label>Client</label>
            <select name="tenant_id" class="form-control" data-live-search="true" id="tenant_id" v-model="form.tenant_id">
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ (isset($tenant->id)) ? 'selected' : old('tenant_id')}}>{{ $tenant->surname }} {{ $tenant->other_names }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Client Address</label>
            <textarea class="form-control" v-model="form.client_address"></textarea>
            <p v-if="errors.client_address" class="error">@{{errors.client_address[0]}}</p>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" data-live-search="true" id="status" v-model="form.status">
                @foreach ($invoice->statusOptions() as $optionKey => $optionValue)
                    <option value="{{ $optionKey }}" {{ (isset($invoice->status) && $invoice->status == $optionKey) ? 'selected' : old('status')}}>{{ $optionValue }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" v-model="form.title">
            <p v-if="errors.title" class="error">@{{errors.title[0]}}</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Invoice Date</label>
                <input type="date" class="form-control" v-model="form.invoice_date">
                <p v-if="errors.invoice_date" class="error">@{{errors.invoice_date[0]}}</p>
            </div>
            <div class="col-sm-6">
                <label>Due Date</label>
                <input type="date" class="form-control" v-model="form.due_date">
                <p v-if="errors.due_date" class="error">@{{errors.due_date[0]}}</p>
            </div>
        </div>
    </div>
</div>
<hr>
<div v-if="errors.products_empty">
    <p class="alert alert-danger">@{{errors.products_empty[0]}}</p>
    <hr>
</div>
<table class="table table-bordered table-form">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="product in form.products">
            <td class="table-name" :class="{'table-error': errors['products.' + $index + '.name']}">
                <textarea class="table-control" v-model="product.name"></textarea>
            </td>
            <td class="table-price" :class="{'table-error': errors['products.' + $index + '.price']}">
                <input type="text" class="table-control"  v-model="product.price">
            </td>
            <td class="table-qty" :class="{'table-error': errors['products.' + $index + '.qty']}">
                <input type="text" class="table-control" v-model="product.qty">
            </td>
            <td class="table-total">
                <span class="table-text">@{{product.qty * product.price}}</span>
            </td>
            <td class="table-remove">
                <span @click="remove(product)" class="btn btn-danger">&times;</span>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="table-empty" colspan="2">
                <span @click="addLine" class="btn btn-primary">Add Line</span>
            </td>
            <td class="table-label">Sub Total</td>
            <td class="table-amount">@{{subTotal}}</td>
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label">Discount</td>
            <td class="table-discount" :class="{'table-error': errors.discount}">
                <input type="text" class="table-discount_input" v-model="form.discount">
            </td>
        </tr>
        <tr>
            <td class="table-empty" colspan="2"></td>
            <td class="table-label">Grand Total</td>
            <td class="table-amount">@{{grandTotal}}</td>
        </tr>
    </tfoot>
</table>