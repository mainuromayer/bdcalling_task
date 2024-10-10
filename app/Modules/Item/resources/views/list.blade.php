@extends('backend.layouts.content')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title pt-2 pb-2"> Item List </h3>
                    <div class="card-tools">
                        <a href="{{ route('item.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Item
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')

    @include('partials.datatable_js')

    <script>
        $(function () {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: '{{ route('item.list') }}',
                    method: 'post',
                    data: function (d) {
                        d._token = $('input[name="_token"]').val(); // CSRF token
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'updated_by', name: 'updated_by' },
                    {
                        data: 'action',
                        name: 'action',
                        render: function (data, type, row) {
                            return `
                                <a href="/item/edit/${row.id}" class="btn btn-sm btn-outline-dark">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger delete-item" data-id="${row.id}">
                                    <i class="fa fa-trash"></i> Delete
                                </button>`;
                        }
                    }
                ],
                aaSorting: []
            });

            // Handle the delete action
            $(document).on('click', '.delete-item', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this item?')) {
                    $.ajax({
                        url: `/item/delete/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: $('input[name="_token"]').val() // CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#list').DataTable().ajax.reload(); // Reload the table after deletion
                                alert('Item deleted successfully.');
                            } else {
                                alert('Something went wrong.');
                            }
                        },
                        error: function() {
                            alert('Error deleting item.');
                        }
                    });
                }
            });
        });
    </script>

@endsection
