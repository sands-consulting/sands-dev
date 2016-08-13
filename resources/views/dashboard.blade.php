@extends('layouts.master')
@section('content')
<h2 class="page-header">Dashboard</h2>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                VMWare
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <p class="lead">
                        <a href="https://vm-console.internal.my-sands.com" target="blank">https://vm-console.internal.my-sands.com</a>
                        <ul class="list-unstyled">
                            <li>Username: {{env('VMWARE_USER')}}</li>
                            <li>Password: {{env('VMWARE_PASS')}}</li>
                            <li>VMRemote:
                                <a download href="/remote-console.dmg">Mac</a>
                                <a download href="/remote-console.msi">Win</a>
                            </li>
                        </ul>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="lead">
                        Teamviewer
                        <ul class="list-unstyled">
                            <li>Username: {{env('TEAMVIEWER_HOST')}}</li>
                            <li>Password: {{env('VMWARE_PASS')}}</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
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
                        <th>Hostname</th>
                        <th>IP</th>
                        <th>State</th>
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
            $.each(response, function(key, val){
                vmsTarget.append('<tr><td>' + val.hostName + '<br/>' + val.guestFullName + '</td><td>' + val.ipAddress + '</td><td>' + val.guestState + '</td></tr>');
            });

            console.log(response);
        });
    </script>
@stop
