<script>
    $('#doc-img').dropify({
        messages: {
            'default': 'Butangi ug picture!',
            'replace': 'Elisi kay wa sya care nimo',
            'remove':  'Buwag na mo!',
            'error':   'Ooops, mirisi.'
        },
        error: {
            'fileSize': 'Daks ra sya',
            'minWidth': 'Mao ni ang pinaka juts',
            'maxWidth': 'Daks ra kaayo',
            'minHeight': 'Mubo ra pud',
            'maxHeight': 'Taas ra pud oi',
            'imageFormat': 'Ingani dapat itsura'
        },
    });

    $('#submit-doc-form').click(function(event) {
            event.preventDefault(); 

            var form = $('#documentation-upload-form');

            var formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: "File successfully uploaded!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Okay'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                },
                error: function(xhr, status, error) {
                    console.error('Request failed with status: ' + status);
                }
            });
    });
</script>