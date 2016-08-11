@extends('layouts.master')

@section('content')
    <h2 class="page-header">
        {{ ucfirst('[[model_plural]]') }}
    </h2>

    <div class="panel panel-default">
        <div class="panel-heading">
            List of {{ ucfirst('[[model_plural]]') }}
        </div>
        <div class="panel-body">
            <div class="">
                <table class="table table-striped" id="thegrid">
                  <thead>
                    <tr>
[[foreach:columns]]
                        <th>[[i.display]]</th>
[[endforeach]]
                        <th style="width:120px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
            <a href="{{url('[[route_path]]/add')}}" class="btn btn-primary" role="button">Add [[model_singular]]</a>
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
                "ajax": "{{url('[[route_path]]/grid')}}",
                "columnDefs": [
                    {
                        visible: false,
                        // hide id, created_at and updated_at columns
                        targets: [0, -2, -3]
                    },
                    {
                        render: function ( data, type, row ) {
                            return '<div class="btn-group"><a href="{{url('[[route_path]]/show')}}/'+row[0]+'" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a> <a href="{{url('[[route_path]]/update')}}/'+row[0]+'" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a> <a href="{{url('[[route_path]]/delete')}}" onclick="return doDelete('+row[0]+')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></div>';
                        },
                        targets: -1
                    },
                ]
            });
        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?') && thegrid) {
                $.ajax('{{url('[[route_path]]/delete')}}/'+id).success(function() {
                    theGrid.ajax.reload();
                });

            }
            return false;
        }
    </script>
@endsection
