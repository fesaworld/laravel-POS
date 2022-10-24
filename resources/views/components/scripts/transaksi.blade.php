<script>
    let cart_id;

    const selectProduct = () => {
        $.ajax({
            type: "get",
            url: `/transaksiProduct/get-product`,
            dataType: "json",
            success: function (response) {
                $('#selectProductTableBody').html('');

                $.each(response.data, function(index, data) {
                    $('#selectProductTableBody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${data.name}</td>
                            <td>${data.product_category}</td>
                            <td>${data.price_sell}</td>
                            <td>${data.stok}</td>
                            <td>
                                ${data.image}
                            </td>
                            <td>
                                <button type="button" onclick="tambahProduct(${data.id})" class="btn btn-primary">Tambah</button>
                            </td>
                        </tr>
                    `);
                });

                $('#selectProductForm').trigger('reset');
                $('#selectProductModal').modal('show');
            }
        });
    }

    const selectMember = () => {
        $.ajax({
            type: "get",
            url: `/transaksiMember/get-member`,
            dataType: "json",
            success: function (response) {
                $('#selectMemberTableBody').html('');

                $.each(response.data, function(index, data) {
                    $('#selectMemberTableBody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${data.name}</td>
                            <td>${data.phone}</td>
                            <td>${data.detail}</td>
                            <td>
                                <button type="button" onclick="tambahMember(${data.id})" class="btn btn-primary">Tambah</button>
                            </td>
                        </tr>
                    `);
                });

                $('#selectMemberModal').modal('show');
            }
        });
    }

    const deleteCart = (id) => {
        Swal.fire({
            title: 'Apa anda yakin untuk menghapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
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
                    url: `/cart/${id}`,
                    dataType: "json",
                    success: function (response) {
                        Swal.close();

                        if(response.status) {
                            Swal.fire(
                                'Success!',
                                response.msg,
                                'success'
                            )

                            $('#totalPrice').val(response.total);
                            $('#viewCartTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.msg,
                                'warning'
                            )
                        }
                    }
                });
            }
        });
    }

    const tambahProduct = (id) => {
        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            type: "get",
            url: `/transaksiProduct/${id}`,
            dataType: "json",
            success: function (response) {
                $('#productId').val(response.id);
                $('#productName').val(response.name);
                Swal.close();
                $('#selectProductModal').modal('hide');
            }
        });
    }

    const tambahMember = (id) => {
        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            type: "get",
            url: `/transaksiMember/${id}`,
            dataType: "json",
            success: function (response) {
                $('#memberId').val(response.id);
                $('#memberName').val(response.name);
                Swal.close();
                $('#selectMemberModal').modal('hide');
            }
        });
    }

    const editCart = (id) => {
        Swal.fire({
            title: 'Mohon tunggu',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading()
            }
        });

        cart_id = id;

        $.ajax({
            type: "get",
            url: `/cart/${cart_id}`,
            dataType: "json",
            success: function (response) {
                $('#cartQuantity').val(response.quantity);
                Swal.close();
                $('#editCartModal').modal('show');
            }
        });
    }

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        //ini buat cart
        $('#viewCartTable').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Semua']],
            filter: true,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {
                url: '/cart/lihatCart'
            },
            "columns":
            [
                { data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'product_name', name:'product.name'},
                { data: 'product_category_name', name:'product_categories.name'},
                { data:'product_image', name:'product.image'},
                { data: 'product_harga', name:'product.price_sell'},
                { data: 'quantity', name:'product.stok'},
                { data: 'subtotal', name:'product.stok'},
                { data: 'action', orderable: false, searchable: false},
            ]

        });

        $('#createCart').click(function (e) {
            e.preventDefault();

            var formData = $('#selectProductForm').serialize();

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
                url: "/cart",
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

                        $('#totalPrice').val(data.total);
                        $('#productId').val('');
                        $('#productName').val('');
                        $('#viewCartTable').DataTable().ajax.reload();
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

        $('#editCartSubmit').click(function (e) {
            e.preventDefault();

            var formData = $('#editCartForm').serialize();

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
                url: `/cart/${cart_id}`,
                data: formData,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data) {

                    if(data.status) {
                        Swal.fire(
                            'Success!',
                            data.msg,
                            'success'
                            )

                            Swal.close();
                        cart_id = null;

                        $('#totalPrice').val(data.total);
                        $('#editCartModal').modal('hide');
                        $('#viewCartTable').DataTable().ajax.reload();
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

        $('#createTransaksi').click(function (e) {
            e.preventDefault();

            var formData = $('#createTransaksiForm').serialize();

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
                url: "/transaksi",
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

                        $('#createTransaksiForm').trigger('reset');
                        $('#viewCartTable').DataTable().ajax.reload();
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
