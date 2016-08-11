@extends('layouts.master')

@section('content')


<h2 class="page-header">Application</h2>

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
                <label for="user_id" class="col-sm-3 control-label">User Id</label>
                <div class="col-sm-6">
                    <input type="text" name="user_id" id="user_id" class="form-control" value="{{$model['user_id'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="zone" class="col-sm-3 control-label">Zone</label>
                <div class="col-sm-6">
                    <input type="text" name="zone" id="zone" class="form-control" value="{{$model['zone'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="forward_proxy_host" class="col-sm-3 control-label">Forward Proxy Host</label>
                <div class="col-sm-6">
                    <input type="text" name="forward_proxy_host" id="forward_proxy_host" class="form-control" value="{{$model['forward_proxy_host'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="enabled_http" class="col-sm-3 control-label">Enabled Http</label>
                <div class="col-sm-2">
                    <input type="number" name="enabled_http" id="enabled_http" class="form-control" value="{{$model['enabled_http'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="enabled_https" class="col-sm-3 control-label">Enabled Https</label>
                <div class="col-sm-2">
                    <input type="number" name="enabled_https" id="enabled_https" class="form-control" value="{{$model['enabled_https'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="created_at" class="col-sm-3 control-label">Created At</label>
                <div class="col-sm-6">
                    <input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label for="updated_at" class="col-sm-3 control-label">Updated At</label>
                <div class="col-sm-6">
                    <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}">
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
