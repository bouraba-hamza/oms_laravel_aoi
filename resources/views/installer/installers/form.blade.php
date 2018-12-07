<div class="form-group {{ $errors->has('fisrt_name') ? 'has-error' : ''}}">
    <label for="fisrt_name" class="col-md-4 control-label">{{ 'Fisrt Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="fisrt_name" type="text" id="fisrt_name" value="{{ $installer->fisrt_name or ''}}" required>
        {!! $errors->first('fisrt_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
    <label for="last_name" class="col-md-4 control-label">{{ 'Last Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="last_name" type="text" id="last_name" value="{{ $installer->last_name or ''}}" >
        {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
    <label for="phone" class="col-md-4 control-label">{{ 'Phone' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ $installer->phone or ''}}" >
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('mail') ? 'has-error' : ''}}">
    <label for="mail" class="col-md-4 control-label">{{ 'Mail' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="mail" type="text" id="mail" value="{{ $installer->mail or ''}}" >
        {!! $errors->first('mail', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('cin') ? 'has-error' : ''}}">
    <label for="cin" class="col-md-4 control-label">{{ 'Cin' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="cin" type="text" id="cin" value="{{ $installer->cin or ''}}" >
        {!! $errors->first('cin', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
