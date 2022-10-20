<script>
    let user_id;

    const create = () => {
        $('#createForm').trigger('reset');
        $('#createModal').modal('show');
    }

    const deleteData = (id) => {
        Swal.fire({
            title: 'Apa anda yakin untuk menghapus barang haram ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, aing tobat',
            cancelButtonText: 'Teu, gas maksiat'
        }).then((result) => {
            Swal.close();

            if(result.value) {
                Swal.fire({
                    title: 'Mohon tunggu',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    type: "delete",
                    url: `/user/${id}`,
                    dataType: "json",
                    cache: false,
                    processData: false,
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
        });
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

        user_id = id;

        $.ajax({
            type: "get",
            url: `/user/${user_id}`,
            dataType: "json",
            success: function (response) {
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#user_role').val(response.role_id);
                Swal.close();
                $('#editModal').modal('show');
            }
        });
    }

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
                url: '/user/lihatUser'
            },
            "columns":
            [
                { data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'name', name:'user.name'},
                { data: 'email', name:'user.detail'},
                { data: 'user_role', name:'status.name'},
                { data: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createSubmit').click(function (e) {
            e.preventDefault();

            var formData = $('#createForm').serialize();

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
                url: "/user",
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data) {
                    Swal.close();

                    if(data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        $('#createModal').modal('hide');
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

        $('#editSubmit').click(function (e) {
            e.preventDefault();

            var formData = $('#editForm').serialize();

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
                url: `/user/${user_id}`,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data) {
                    Swal.close();

                    if(data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                        )

                        user_id = null;
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
