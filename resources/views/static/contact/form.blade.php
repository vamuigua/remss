<div class="row">
    <input type="hidden" name="subject" value="Contact">
    <div class="col-md-6 form-group" {{ $errors->has('name') ? 'has-error' : ''}}">
        <input class="form-control" name="name" type="text" id="subject" placeholder="Your name" value="{{ old('name') }}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-6 form-group" {{ $errors->has('email') ? 'has-error' : ''}}">
        <input class="form-control" name="email" type="email" id="email" placeholder="Your email" value="{{ old('email') }}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-12 form-group">
        <textarea name="message"  placeholder="Your message"></textarea>
        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
        <button class="site-btn">SUMMIT NOW</button>
    </div>
</div>