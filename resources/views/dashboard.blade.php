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
                <div class="col-md-4">
                    <p class="lead">
                        VM Console
                    </p>
                    <ul class="list-unstyled">
                        <li></li>
                        <li>Link: <a href="https://vm-console.internal.my-sands.com" target="blank">https://vm-console.internal.my-sands.com</a></li>
                        <li>Username: {{env('VMWARE_USER')}}</li>
                        <li>Password: {{env('VMWARE_PASS')}}</li>
                        <li>VMRemote:
                            <a download href="/remote-console.dmg">Mac</a>
                            <a download href="/remote-console.msi">Win</a>
                        </li>
                    </ul>
                    <p class="alert alert-sm alert-warning">
                        <b>Must be either in office network or connected to VPN first!</b>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="lead">
                        Teamviewer
                        <ul class="list-unstyled">
                            <li>Username: {{env('TEAMVIEWER_HOST')}}</li>
                            <li>Password: {{env('VMWARE_PASS')}}</li>
                        </ul>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="lead">
                        VPN
                        <ul class="list-unstyled">
                            <li>Installation: <code>brew install sshuttle</code></li>
                            <li>Command: <code>sshuttle -r ubuntu@dev.my-sands.com 192.168.8.0/24</code></li>
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
                <button id="refreshIps" onclick="getIps()" class="btn btn-primary pull-right btn-xs">
                    <i class="fa fa-refresh"></i>
                </button>
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
        function getIps() {
            var ipsTarget = $('#ipsTarget');
            ipsTarget.html('<tr><td colspan="3">Loading...</td></tr>');
            $.getJSON('/dashboard/ips', function(response){
                ipsTarget.html('');
                $.each(response, function(key, val){
                    ipsTarget.append('<tr><td>' + val.ip + '</td><td>' + val.mac + '</td><td>' + val.description + '</td></tr>');
                });
            });
        }
        getIps();
    </script>
@stop
