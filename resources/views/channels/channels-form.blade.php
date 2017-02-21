<form method="POST" action="{{ route('channels.add') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-5">
            <div class="form-group {{ $errors->has('repository') ? 'has-error': '' }}">
                <label for="repository">Repository</label>
                <input type="text" class="form-control" name="repository">
                <p class="help-block">{{ $errors->first('repository') }}</p>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group {{ $errors->has('destination') ? 'has-error': '' }}">
                <label for="destination">Destination</label>
                <input type="text" class="form-control" name="destination">
                <p class="help-block">{{ $errors->first('destination') }}</p>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <button class="btn btn btn-success form-control" type="submit">Add</button>

            </div>
        </div>
    </div>
</form>