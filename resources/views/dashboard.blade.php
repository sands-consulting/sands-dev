@extends('layouts.master')
@section('content')
<h2 class="page-header">Dashboard</h2>
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
<div class="panel panel-default">
    <div class="panel-heading">
        Applications
    </div>
    <div class="panel-body">
    </div>
</div>
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
    </script>
@stop
