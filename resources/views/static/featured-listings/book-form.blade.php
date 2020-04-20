<input type="hidden" name="subject" value="House Booking Request">
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="first_name">First Name</label>
        <div {{ $errors->has('first_name') ? 'has-error' : ''}}">
            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" value="{{ old('first_name') }}" required>
            {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        <label for="last_name">Last Name</label>
        <div {{ $errors->has('last_name') ? 'has-error' : ''}}">
            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name" value="{{ old('last_name') }}" required>
            {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <div {{ $errors->has('email') ? 'has-error' : ''}}">
            <input type="email" class="form-control" name="email" id="email" placeholder="user@gmail.com" value="{{ old('email') }}" required>
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        <label for="national_id">National ID</label>
            <div {{ $errors->has('national_id') ? 'has-error' : ''}}">
            <input type="text" class="form-control" name="national_id" id="national_id" placeholder="34565928" value="{{ old('national_id') }}" required>
            {!! $errors->first('national_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label for="phone_no">Phone No.</label>
    <div {{ $errors->has('phone_no') ? 'has-error' : ''}}">
        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="254712121212" value="{{ old('phone_no') }}" required>
        {!! $errors->first('phone_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <div class="checkbox">
    <div {{ $errors->has('agreement_checkbox') ? 'has-error' : ''}}">
        <label for="agreement_checkbox">
            <input type="checkbox" name="agreement_checkbox"> I agree to the <a href="#">Terms and Conditions</a>
        </label>
         {!! $errors->first('agreement_checkbox', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<button type="submit" class="btn btn-primary">Submit</button>