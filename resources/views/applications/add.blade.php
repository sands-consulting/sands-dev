@extends('layouts.master')

@section('content')


<h2 class="page-header">Application</h2>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        Add/Modify Application    </div>

    <div class="panel-body">
        @if($__mode == 'create')
        <form action="{{ url('/applications/save') }}" method="POST" class="form-horizontal">
        @else
        <form action="{{ url('/applications/save/' . $model['id']) }}" method="POST" class="form-horizontal">
        @endif
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control" value="{{$model['name'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="zone" class="col-sm-3 control-label">Zone</label>
                <div class="col-sm-6">
                    <input type="text" name="zone" id="zone" class="form-control" value="{{$model['zone'] or ''}}">
                    <div class="help">
                        Fully qualified domain name: reach.my-sands.com. DNS must be pointed to Sands's IP address first.
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="forward_proxy_host" class="col-sm-3 control-label">Forward Proxy Host</label>
                <div class="col-sm-6">
                    <input type="text" name="forward_proxy_host" id="forward_proxy_host" class="form-control" value="{{$model['forward_proxy_host'] or '192.168.8.'}}">
                    <div class="help">
                        Internal IP address of web server: 192.168.8.31
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="enabled_http" class="col-sm-3 control-label">Enabled Http</label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label>
                            <input type="radio" value="1" name="enabled_http" id="enabled_http" @if((isset($model) && $model['enabled_http']) || !isset($model)) checked @endif>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" value="0" name="enabled_http" id="enabled_http" @if(isset($model) && !$model['enabled_http']) checked @endif>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="enabled_https" class="col-sm-3 control-label">Enabled Https</label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label>
                            <input type="radio" value="1" name="enabled_https" id="enabled_https" @if((isset($model) && $model['enabled_https']) || !isset($model)) checked @endif>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" value="0" name="enabled_https" id="enabled_https" @if(isset($model) && !$model['enabled_https']) checked @endif>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Save
                    </button>
                    <a class="btn btn-default" href="{{ url('/applications') }}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>
        </form>
    </div>
</div>






@endsection
