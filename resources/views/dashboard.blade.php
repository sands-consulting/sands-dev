@extends('layouts.master')
@section('content')
<h2 class="page-header">Dashboard</h2>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Used IPs
            </div>
            <table class="panel-body table">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>MAC</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="ipsTarget">
                    <tr>
                        <td colspan="3">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                VMS
            </div>
            <table class="panel-body table">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>MAC</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="vmsTarget">
                    <tr>
                        <td colspan="3">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- <div class="panel panel-default">
    <div class="panel-heading">
        Applications
    </div>
    <div class="panel-body">
    </div>
</div> --}}
@endsection

@section('scripts')
    <script type="text/javascript">
        var ipsTarget = $('#ipsTarget');
        $.getJSON('/dashboard/ips', function(response){
            ipsTarget.html('');
            $.each(response, function(key, val){
                ipsTarget.append('<tr><td>' + val.ip + '</td><td>' + val.mac + '</td><td>' + val.description + '</td></tr>');
            });
        });
        var vmsTarget = $('#vmsTarget');
        $.getJSON('/dashboard/vms', function(response){
            vmsTarget.html('');
            console.log(response);
        });
    </script>
@stop
