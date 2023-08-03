{{-- SB Admin Scripts --}}
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    {{-- <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}

    

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
                cancelButtonText: 'Bata pa diay!',
                reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

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
                            location.reload();
                        }
                    })
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle any errors if necessary
            });
                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Okay, next time na lang!',
                'Wa madayon kay bata pa.',
                'error'
                )
            }
            })
        }
    </script>
</body>
</html>