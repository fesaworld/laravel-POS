<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('#table').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Semua']],
            filter: true,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {
                url: '/stockLog/lihatLog'
            },
            "columns":
            [
                { data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'product_name', name:'products.name'},
                { data: 'supplier_name', name:'suppliers.name'},
                { data: 'user_name', name:'users.name'},
                { data: 'in', name:'stock_log.in'},
                { data: 'out', name:'stock_log.out'},
                { data: 'created_at', name:'stock_log.created_at'},
                { data: 'detail', name:'stock_log.detail'},
            ]
        });
    });
</script>
