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
                        <th>User Id</th>
                        <th>Zone</th>
                        <th>Forward Proxy Host</th>
                        <th>Enabled Http</th>
                        <th>Enabled Https</th>
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
                            return '<div class="btn-group"><a href="{{url('applications/show')}}/'+row[0]+'" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a> <a href="{{url('applications/update')}}/'+row[0]+'" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a> <a href="{{url('applications/delete')}}" onclick="return doDelete('+row[0]+')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></div>';
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
    </script>
@endsection
