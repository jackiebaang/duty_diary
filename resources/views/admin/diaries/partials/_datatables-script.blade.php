<script>
    $(document).ready( function () {
        $('#diaries-table').DataTable({
            initComplete: function(){
                $('.dataTables_filter ').append('<a href="{{ route("diaries.create") }}" class="btn btn-sm btn-primary ml-3">New Diary</a>');
            },
            processing: true,
            serverSide: true,
            ajax: '{{ route('diaries.index') }}',
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'index'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'status',
                    name: 'status'
                },
    
            ],
            "order": [[ 3, 'asc']]
    
        });
    } );
    </script>