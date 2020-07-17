<div class="form-group {{ $errors->has('event_name') ? 'has-error' : ''}}">
    <label for="event_name" class="control-label">{{ 'Event Name' }}</label>
    <input class="form-control" name="event_name" type="text" id="event_name" value="{{ isset($event->event_name) ? $event->event_name : ''}}" >
    {!! $errors->first('event_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
    <label for="start_date" class="control-label">{{ 'Start Date' }}</label>
    <input class="form-control" name="start_date" type="date" id="start_date" value="{{ isset($event->start_date) ? $event->start_date : ''}}" >
    {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
    <label for="end_date" class="control-label">{{ 'End Date' }}</label>
    <input class="form-control" name="end_date" type="date" id="end_date" value="{{ isset($event->end_date) ? $event->end_date : ''}}" >
    {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
