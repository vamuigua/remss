<div class="form-group {{ $errors->has('message') ? 'has-error' : ''}}">
    <label for="message" class="control-label">{{ 'Message' }}</label>
    <textarea class="form-control" rows="5" name="message" type="textarea" id="message" >{{ old('message') ?? $message->message }}</textarea>
    {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('send_to') ? 'has-error' : ''}}">
    <label for="send_to" class="control-label">{{ 'Send To:' }}</label>
    <select name="send_to" class="form-control" id="send_to" onchange="toggleImport()">
        <option value="all_tenants">All Tenants</option>
        <option value="excel">From Excel</option>
    </select>
    {!! $errors->first('send_to', '<p class="help-block">:message</p>') !!}
</div>

{{-- Hidden element for Importing Excel File with Phone Numbers --}}
<div class="form-group {{ $errors->has('import_file') ? 'has-error' : ''}}" style="display:none" id="importFile">
    <label for="import_file" class="control-label">{{ 'Import Phone No. Excel File ' }} <i>(.xlsx only)</i>:</label>
    <br>
    <input accept=".xlsx, .xls, .csv" type="file" name="import_file"  value="{{ old('import_file') }}" />
    {!! $errors->first('import_file', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Send Message' }}">
</div>

<script src="{{ asset('js/fetch.js') }}" type="text/javascript"></script>
