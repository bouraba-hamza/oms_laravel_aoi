<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    <label for="type" class="col-md-4 control-label">{{ 'Type' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="type" type="text" id="type" value="{{ $interventiondetail->type or ''}}" >
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('observation') ? 'has-error' : ''}}">
    <label for="observation" class="col-md-4 control-label">{{ 'Observation' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="observation" type="text" id="observation" value="{{ $interventiondetail->observation or ''}}" >
        {!! $errors->first('observation', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="col-md-4 control-label">{{ 'Status' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="status" type="text" id="status" value="{{ $interventiondetail->status or ''}}" >
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('vehicle_id') ? 'has-error' : ''}}">
    <label for="vehicle_id" class="col-md-4 control-label">{{ 'Vehicle Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="vehicle_id" type="number" id="vehicle_id" value="{{ $interventiondetail->vehicle_id or ''}}" >
        {!! $errors->first('vehicle_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('intervention_id') ? 'has-error' : ''}}">
    <label for="intervention_id" class="col-md-4 control-label">{{ 'Intervention Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="intervention_id" type="number" id="intervention_id" value="{{ $interventiondetail->intervention_id or ''}}" >
        {!! $errors->first('intervention_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
    <label for="created_by" class="col-md-4 control-label">{{ 'Created By' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="created_by" type="number" id="created_by" value="{{ $interventiondetail->created_by or ''}}" >
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
