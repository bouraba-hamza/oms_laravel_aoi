<div class="form-group {{ $errors->has('provider') ? 'has-error' : ''}}">
    <label for="provider" class="col-md-4 control-label">{{ 'Provider' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="provider" type="text" id="provider" value="{{ $order->provider or ''}}" >
        {!! $errors->first('provider', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('order_ref') ? 'has-error' : ''}}">
    <label for="order_ref" class="col-md-4 control-label">{{ 'Order Ref' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="order_ref" type="text" id="order_ref" value="{{ $order->order_ref or ''}}" >
        {!! $errors->first('order_ref', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('plan') ? 'has-error' : ''}}">
    <label for="plan" class="col-md-4 control-label">{{ 'Plan' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="plan" type="text" id="plan" value="{{ $order->plan or ''}}" >
        {!! $errors->first('plan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('date_arrived') ? 'has-error' : ''}}">
    <label for="date_arrived" class="col-md-4 control-label">{{ 'Date Arrived' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="date_arrived" type="date" id="date_arrived" value="{{ $order->date_arrived or ''}}" >
        {!! $errors->first('date_arrived', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('state') ? 'has-error' : ''}}">
    <label for="state" class="col-md-4 control-label">{{ 'State' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="state" type="text" id="state" value="{{ $order->state or ''}}" >
        {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('observtion') ? 'has-error' : ''}}">
    <label for="observtion" class="col-md-4 control-label">{{ 'Observtion' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="observtion" type="text" id="observtion" value="{{ $order->observtion or ''}}" >
        {!! $errors->first('observtion', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('quantity') ? 'has-error' : ''}}">
    <label for="quantity" class="col-md-4 control-label">{{ 'Quantity' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="quantity" type="text" id="quantity" value="{{ $order->quantity or ''}}" >
        {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
    <label for="category" class="col-md-4 control-label">{{ 'Category' }}</label>
    <div class="col-md-6">
        <select name="category" class="form-control" id="category" >
    @foreach (json_decode('{"1":"Boitier","2":"SIM"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($order->category) && $order->category == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
        {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('created_by') ? 'has-error' : ''}}">
    <label for="created_by" class="col-md-4 control-label">{{ 'Created By' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="created_by" type="number" id="created_by" value="{{ $order->created_by or ''}}" >
        {!! $errors->first('created_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
