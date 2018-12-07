<div class="form-group {{ $errors->has('intervention__detail_id') ? 'has-error' : ''}}">
    <label for="intervention__detail_id" class="col-md-4 control-label">{{ 'Intervention  Detail Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="intervention__detail_id" type="number" id="intervention__detail_id" value="{{ $interventiondetailsproduct->intervention__detail_id or ''}}" >
        {!! $errors->first('intervention__detail_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('installer_product_id') ? 'has-error' : ''}}">
    <label for="installer_product_id" class="col-md-4 control-label">{{ 'Installer Product Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="installer_product_id" type="number" id="installer_product_id" value="{{ $interventiondetailsproduct->installer_product_id or ''}}" >
        {!! $errors->first('installer_product_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
    <label for="created_by" class="col-md-4 control-label">{{ 'Created By' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="created_by" type="number" id="created_by" value="{{ $interventiondetailsproduct->created_by or ''}}" >
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
