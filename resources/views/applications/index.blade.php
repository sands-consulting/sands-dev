@extends('layouts.master')

@section('content')
    <h2 class="page-header">
        {{ ucfirst('applications') }}
    </h2>

    <div class="panel panel-default">
        <div class="panel-heading">
            List of {{ ucfirst('applications') }}
        </div>
        <div class="panel-body">
            <div class="">
                <table class="table table-striped" id="thegrid">
                  <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Zone</th>
                        <th>Forward Proxy Host</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th style="width:120px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
            <a href="{{url('applications/add')}}" class="btn btn-primary" role="button">Add application</a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <button id="refreshVm" onclick="getVms()" class="btn btn-primary pull-right btn-xs">
                <i class="fa fa-refresh"></i>
            </button>
            VMS
        </div>
        <table class="panel-body table">
            <thead>
                <tr>
                    <th>State</th>
                    <th>Hostname</th>
                    <th>OS</th>
                    <th>IP</th>
                    <th>Annotations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="vmsTarget">
                <tr>
                    <td colspan="3">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection


@section('scripts')
    <script type="text/javascript">
        var theGrid = null;
        $(document).ready(function(){
            theGrid = $('#thegrid').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "responsive": true,
                "ajax": "{{url('applications/grid')}}",
                "columnDefs": [
                    {
                        visible: false,
                        // hide id, created_at and updated_at columns
                        targets: [0, -2, -3]
                    },
                    {
                        render: function ( data, type, row ) {
                            return '<div class="btn-group"><a href="{{url('applications/show')}}/'+row[0]+'" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a> <a href="{{url('applications/update')}}/'+row[0]+'" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a> <a href="{{url('applications/delete')}}/'+row[0]+'" onclick="return doDelete('+row[0]+')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></div>';
                        },
                        targets: -1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?') && thegrid) {
                $.ajax('{{url('applications/delete')}}/'+id).success(function() {
                    theGrid.ajax.reload();
                });

            }
            return false;
        }
        function getVms() {
            var vmsTarget = $('#vmsTarget');
            vmsTarget.html('<tr><td colspan="6">Loading...</td></tr>');
            $.getJSON('/dashboard/vms', function(response){
                vmsTarget.html('');
                $.each(response, function(key, val){
                    var buttons = '<a class="btn btn-xs btn-default" href="https://vm-console.internal.my-sands.com/ui/#/console/' + val.id + '" target="blank"><i class="fa fa-desktop"></i></a> ';
                    if(val.ipAddress) {
                        if(val.guestFamily  == 'linuxGuest') {
                            buttons = buttons + '<a class="btn btn-xs btn-default" href="ssh://ubuntu@' + val.ipAddress + '" target="blank"><i class="fa fa-terminal"></i></a>'
                        } else {
                            buttons = buttons + '<a class="btn btn-xs btn-default" href="rdp://full%20address=s:' + val.ipAddress + '" target="blank"><i class="fa fa-terminal"></i></a>'
                        }
                    }
                    vmsTarget.append('<tr><td>' + val.guestState + '</td><td>' + val.hostName + '</td><td>' + val.guestFullName + '</td><td>' + val.ipAddress + '</td><td>' + val.annotations + '</td><td>' + buttons + '</td></tr>');
                });
            });
        }
        getVms();
    </script>
@endsection
