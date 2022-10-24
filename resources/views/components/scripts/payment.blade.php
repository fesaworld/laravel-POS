<script>
    let transaction_id;

    // const create = () => {
    //     $('#createForm').trigger('reset');
    //     $('#createModal').modal('show');
    // }

    // const deleteData = (id) => {
    //     Swal.fire({
    //         title: 'Apa anda yakin untuk menghapus?',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Ya',
    //         cancelButtonText: 'Tidak'
    //     }).then((result) => {
    //         Swal.close();

    //         if(result.value) {
    //             Swal.fire({
    //                 title: 'Mohon tunggu',
    //                 showConfirmButton: false,
    //                 allowOutsideClick: false,
    //                 willOpen: () => {
    //                     Swal.showLoading()
    //                 }
    //             });

    //             $.ajax({
    //                 type: "delete",
    //                 url: `/product/${id}`,
    //                 dataType: "json",
    //                 cache: false,
    //                 processData: false,
    //                 success: function(data) {
    //                     Swal.close();

    //                     if(data.status) {
    //                         Swal.fire(
    //                             'Success!',
    //                             data.msg,
    //                             'success'
    //                         )

    //                         $('#table').DataTable().ajax.reload();
    //                     } else {
    //                         Swal.fire(
    //                             'Error!',
    //                             data.msg,
    //                             'warning'
    //                         )
    //                     }
    //                 }
    //             })
    //         }
    //     });
    // }

    const editStatus = (id) => {
        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            type: "post",
            url: `/transactionStatus/${id}`,
            dataType: "json",
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                Swal.close();

                if(data.status) {
                    Swal.fire(
                        'Success!',
                        data.msg,
                        'success'
                    )

                    $('#table').DataTable().ajax.reload();
                } else {
                    Swal.fire(
                        'Error!',
                        data.msg,
                        'warning'
                    )
                }
            }
        })
    }

    const edit = (id) => {
        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });

        transaction_id = id;

        $.ajax({
            type: "get",
            url: `/transaction/${transaction_id}`,
            dataType: "json",
            success: function (response) {
                $('#name').val(response.name);
                $('#user_id').val(response.user_id);
                $('#member_id').val(response.member_id);
                $('#total').val(response.total);
                $('#status').val(response.status);
                $('#editModal').modal('show');
                Swal.close();

            }
        });

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
                url: `/payment/${transaction_id},`
            },
            "columns":
            [
                { data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'name', name:'user.name'},
                { data: 'member', name:'members.name'},
                { data: 'total', name:'total'},
                { data: 'status', name:'status'},
                { data: 'action', orderable: false, searchable: false},
            ]
        });

        $('#editSubmit').click(function (e) {
            e.preventDefault();

            var formData = new FormData($('#editForm')[0]);

            Swal.fire({
                title: 'Mohon tunggu',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                type: "post",
                url: `/product/${product_id}`,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.close();

                    if(data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        product_id = null;
                        $('#editModal').modal('hide');
                        $('#table').DataTable().ajax.reload();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'warning'
                        )
                    }
                }
            })
        });
    });
</script>
