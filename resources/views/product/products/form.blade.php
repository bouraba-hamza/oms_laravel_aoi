<div class="form-group {{ $errors->has('imei_product') ? 'has-error' : ''}}">
    <label for="imei_product" class="col-md-4 control-label">{{ 'Imei Product' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="imei_product" type="text" id="imei_product" value="{{ $product->imei_product or ''}}" required>
        {!! $errors->first('imei_product', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('numero') ? 'has-error' : ''}}">
    <label for="numero" class="col-md-4 control-label">{{ 'Numero' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="numero" type="text" id="numero" value="{{ $product->numero or ''}}" >
        {!! $errors->first('numero', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('model') ? 'has-error' : ''}}">
    <label for="model" class="col-md-4 control-label">{{ 'Model' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="model" type="text" id="model" value="{{ $product->model or ''}}" >
        {!! $errors->first('model', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('available') ? 'has-error' : ''}}">
    <label for="available" class="col-md-4 control-label">{{ 'Available' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="available" type="text" id="available" value="{{ $product->available or ''}}" >
        {!! $errors->first('available', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('enabled_date') ? 'has-error' : ''}}">
    <label for="enabled_date" class="col-md-4 control-label">{{ 'Enabled Date' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="enabled_date" type="date" id="enabled_date" value="{{ $product->enabled_date or ''}}" >
        {!! $errors->first('enabled_date', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
    <label for="state" class="col-md-4 control-label">{{ 'State' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="state" type="text" id="state" value="{{ $product->state or ''}}" >
        {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
    <label for="category" class="col-md-4 control-label">{{ 'Category' }}</label>
    <div class="col-md-6">
        <select name="category" class="form-control" id="category" >
    @foreach (json_decode('{"1":"Boitier","2":"SIM"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($product->category) && $product->category == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
        {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('order_id') ? 'has-error' : ''}}">
    <label for="order_id" class="col-md-4 control-label">{{ 'Order Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="order_id" type="number" id="order_id" value="{{ $product->order_id or ''}}" >
        {!! $errors->first('order_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('observation') ? 'has-error' : ''}}">
    <label for="observation" class="col-md-4 control-label">{{ 'Observation' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="observation" type="text" id="observation" value="{{ $product->observation or ''}}" >
        {!! $errors->first('observation', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
    <label for="created_by" class="col-md-4 control-label">{{ 'Created By' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="created_by" type="number" id="created_by" value="{{ $product->created_by or ''}}" >
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
