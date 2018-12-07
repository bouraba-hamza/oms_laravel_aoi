<div class="form-group {{ $errors->has('intervened_at') ? 'has-error' : ''}}">
    <label for="intervened_at" class="col-md-4 control-label">{{ 'Intervened At' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="intervened_at" type="date" id="intervened_at" value="{{ $intervention->intervened_at or ''}}" >
        {!! $errors->first('intervened_at', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('observation') ? 'has-error' : ''}}">
    <label for="observation" class="col-md-4 control-label">{{ 'Observation' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="observation" type="text" id="observation" value="{{ $intervention->observation or ''}}" >
        {!! $errors->first('observation', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="col-md-4 control-label">{{ 'Status' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="status" type="text" id="status" value="{{ $intervention->status or ''}}" >
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('responsible_validation') ? 'has-error' : ''}}">
    <label for="responsible_validation" class="col-md-4 control-label">{{ 'Responsible Validation' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="responsible_validation" type="text" id="responsible_validation" value="{{ $intervention->responsible_validation or ''}}" >
        {!! $errors->first('responsible_validation', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('costumer_id') ? 'has-error' : ''}}">
    <label for="costumer_id" class="col-md-4 control-label">{{ 'Costumer Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="costumer_id" type="number" id="costumer_id" value="{{ $intervention->costumer_id or ''}}" >
        {!! $errors->first('costumer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('intervener_id') ? 'has-error' : ''}}">
    <label for="intervener_id" class="col-md-4 control-label">{{ 'Intervener Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="intervener_id" type="number" id="intervener_id" value="{{ $intervention->intervener_id or ''}}" >
        {!! $errors->first('intervener_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
    <label for="created_by" class="col-md-4 control-label">{{ 'Created By' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="created_by" type="number" id="created_by" value="{{ $intervention->created_by or ''}}" >
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
