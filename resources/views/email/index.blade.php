<!DOCTYPE html>
<html>

<head>
    <title>
        Import Export Excel & CSV to Database - Laravel 10 Yajra Datatables Example
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha3/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.75) no-repeat center center;
            background-size: 100px;
            z-index: 10000;
        }

        .spinner-border {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -50px;
            z-index: 10000;

        }
    </style>
</head>

<body>

    <div id="loader">
        <div class="spinner-border text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <h2 class="mb-4">
            Import Export Excel & CSV to Database - Laravel Yajra Datatables Example
        </h2>
        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="kt_modal_1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" id="payment_modal">
                    <h3 class="fw-bolder m-0">Details Payment</h3>
                </div>
                <div class="modal-body">
                    <form id="payment" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label>
                                        Email
                                    </label>
                                    <input class="form-control" id="email" name="email" type="text" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label>
                                        Code
                                    </label>
                                    <input class="form-control" id="code" name="code" type="text" required>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
    $(function() {

        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user-email.data') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

    });

    $(document).on('click', '#view', function(event, x) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        let id = $('#id').val();
        var data = {
            _token: '{{ csrf_token() }}',
            id: id
        };

        $('#loader').show();
        $.ajax({
            url: href,
            data: data,

            // return the result
            success: function(result) {
                var data = result.list;
                console.log(data);
                $('#loader').hide();
                $('#id').val(data.id);
                $('#email').val(data.email);
                $('#code').val(data.code);

                $('#kt_modal_1').modal('show');
            },
            complete: function() {},
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        })
    });

    $('#payment').submit(function(e) {


        e.preventDefault();

        $('#loader').show();

        let formData = new FormData(this);
        let id = $('#id').val();

        $.ajax({
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            type: 'POST',
            url: "{{ url('user-email/update/') }}" + '/' + id,
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                this.reset();
                $('#loader').hide();
                alert("Success");
                $("#kt_modal_1").modal('hide');
                $('.yajra-datatable').DataTable().ajax.reload();
            },
            error: function(response) {
                $('#loader').hide();
                alert("Error");
            }
        });


    });
</script>

</html>