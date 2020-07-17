<div class="form-group {{ $errors->has('event_name') ? 'has-error' : ''}}">
    <label for="event_name" class="control-label">{{ 'Event Name' }}</label>
    <input class="form-control" name="event_name" type="text" id="event_name" value="{{ isset($event->event_name) ? $event->event_name : old('event_name')}}" >
    {!! $errors->first('event_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Event description' }}</label>
    <textarea class="form-control" rows="5" name="description">{{ isset($event->description) ? $event->description : old('description') }}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('all_day') ? 'has-error' : ''}}">
    <label for="all_day" class="control-label">{{ 'All Day' }}</label>
    <select name="all_day" class="form-control" id="all_day">
        @foreach ($event->fullDayOptions() as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($event->all_day) && $event->all_day == $optionKey) ? 'selected' : old('all_day')}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('all_day', '<p class="help-block">:message</p>') !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
        <label for="start_date" class="control-label">{{ 'Start Date' }}</label>
        <input class="form-control" name="start_date" type="date" id="start_date" value="{{ isset($event->start_date) ? $event->start_date : old('start_date')}}" >
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
    </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
            <label for="end_date" class="control-label">{{ 'End Date' }}</label>
            <input class="form-control" name="end_date" type="date" id="end_date" value="{{ isset($event->end_date) ? $event->end_date : old('end_date')}}" >
            {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row" id="event_time">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('start_time') ? 'has-error' : ''}}">
        <label for="start_time" class="control-label">{{ 'Start Time' }}</label>
        <input class="form-control" name="start_time" type="time" id="start_time" value="{{ isset($event->start_time) ? $event->start_time : old('start_time')}}" >
        {!! $errors->first('start_time', '<p class="help-block">:message</p>') !!}
    </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('end_time') ? 'has-error' : ''}}">
            <label for="end_time" class="control-label">{{ 'End Time' }}</label>
            <input class="form-control" name="end_time" type="time" id="end_time" value="{{ isset($event->end_time) ? $event->end_time : old('end_time')}}" >
            {!! $errors->first('end_time', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('bg_color') ? 'has-error' : ''}}">
    <label for="end_date" class="control-label">{{ 'Background Color' }}</label>
    <select name="bg_color" class="form-control"  id="bg_color">
        @foreach ($event->colorOptions() as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($event->bg_color) && $event->bg_color == $optionKey) ? 'selected' : old('bg_color')}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('bg_color', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
