<div class="row">

    <div class="col-md-12 form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
        <label for="subject" class="control-label">{{ 'Subject' }}</label>
        <select name="subject" class="form-control" id="subject">
            <option value="Question">Question</option>
            <option value="Feedback">Feedback</option>
        </select>
        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-6 form-group" {{ $errors->has('name') ? 'has-error' : ''}}">
        <label for="name" class="control-label">{{ 'Name' }}</label>
        <input class="form-control" name="name" type="text" id="subject" placeholder="Your name" value="{{ old('name') }}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-6 form-group" {{ $errors->has('email') ? 'has-error' : ''}}">
        <label for="email" class="control-label">{{ 'Email' }}</label>
        <input class="form-control" name="email" type="email" id="email" placeholder="Your email" value="{{ old('email') }}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class=" col-md-12 form-group {{ $errors->has('message') ? 'has-error' : ''}}">
        <label for="message" class="control-label">{{ 'Message' }}</label>
        <textarea class="form-control" placeholder="Your message" rows="5" name="message" type="textarea">{{ old('message') }}</textarea>
        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-md-6 form-group">
        <a href="{{ url('/user/questions') }}" title="Send Message"><button class="btn btn-primary"><i class="fas fa-paper-plane" aria-hidden="true"></i> Send Message</button></a>
    </div>
</div>