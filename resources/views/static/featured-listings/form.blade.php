<input type="hidden" name="subject" value="Featured Listing Question">

<div {{ $errors->has('name') ? 'has-error' : ''}}">
    <input type="text"  name="name" id="name" placeholder="Your name" value="{{ old('name') }}">
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div {{ $errors->has('email') ? 'has-error' : ''}}">    
    <input type="email" name="email" id="email" placeholder="Your email" value="{{ old('email') }}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div {{ $errors->has('message') ? 'has-error' : ''}}">
    <textarea name="message" placeholder="Your question"></textarea>
    {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
</div>

<button>SEND</button>