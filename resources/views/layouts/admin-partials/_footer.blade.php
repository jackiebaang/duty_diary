    {{-- SB Admin Scripts --}}
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    {{-- <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}

    {{-- LightBox --}}
    <script src="{{ asset('js/lightbox.js') }}"></script>

    {{-- DataTables --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    {{-- Delete Script --}}
    <script>
        function confirmDelete(id){
            let userId = id;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Sure ka kol?',
                text: "Ayaw kol! Virgin pa ko kol!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Kumbati! Mas lami ang virgin!',
                cancelButtonText: 'Sige, next year na lang.',
                reverseButtons: true
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: `/users/${userId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Virginan lage',
                                text: "Navirginan na jud ang user.",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Okay'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#users-table').DataTable().ajax.reload();
                                }
                            })

                        },
                        error: function(error) {
                            // Handle error response
                            console.error('DELETE request failed:', error);
                        }
                    });
                } else {
                    result.dismiss == Swal.DismissReason.cancel;
                    swalWithBootstrapButtons.fire(
                        'Okay, next time na lang!',
                        'Wa madayon kay bata pa.',
                        'error'
                    );
                }
            })
        }

        function confirmDeleteDiary(id){
            let userId = id;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Sure ka kol?',
                text: "Ayaw kol! Virgin pa ko kol!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Kumbati! Mas lami ang virgin!',
                cancelButtonText: 'Sige, next year na lang.',
                reverseButtons: true
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: `/diaries/${userId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Virginan lage',
                                text: "Navirginan na jud ang user.",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Okay'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#diaries-table').DataTable().ajax.reload();
                                }
                            })

                        },
                        error: function(error) {
                            // Handle error response
                            console.error('DELETE request failed:', error);
                        }
                    });
                } else {
                    result.dismiss == Swal.DismissReason.cancel;
                    swalWithBootstrapButtons.fire(
                        'Okay, next time na lang!',
                        'Wa madayon kay bata pa.',
                        'error'
                    );
                }
            })
        }
    </script>

    {{-- TinyMCE Script --}}
    <script>
        tinymce.init({
          selector: 'textarea',
          plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
</body>
</html>