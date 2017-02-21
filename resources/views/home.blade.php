@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Channels</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('channels.channels-form')
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            @include('channels.channels-table', ['channels' => $channels])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
