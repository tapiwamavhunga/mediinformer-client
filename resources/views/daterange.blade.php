<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Filter Data Between Two Dates in Yajra Datatables in Laravel Example : NiceSnippets.com</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

</head>

<body>

<div class="container">    

    <br />

    <div class="row">

        <h3 class="col-md-9" style="padding: 5px 15px; margin:0px;">Filter Data Between Two Dates in Yajra Datatables in Laravel Example</h3>

        <strong class="col-md-3" style="font-size: 25px; color:#008B8B">NiceSnippets.com</strong>

    </div>

    <br />

    <br />

    <div class="row input-daterange">

        <div class="col-md-4">

            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />

        </div>

        <div class="col-md-4">

            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />

        </div>

        <div class="col-md-4">

            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>

            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>

        </div>

    </div>

    <br />

    <div class="table-responsive">

        <table class="table table-bordered table-striped" id="order_table">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Date</th>

                </tr>

            </thead>

        </table>

    </div>

</div>

<script>

    $(document).ready(function(){

        $('.input-daterange').datepicker({

            todayBtn:'linked',

            format:'yyyy-mm-dd',

            autoclose:true

        });


        load_data();


        function load_data(from_date = '', to_date = ''){

            $('#order_table').DataTable({

                processing: true,

                serverSide: true,

                ajax: {

                    url:'{{ route("daterange.index") }}',

                    data:{from_date:from_date, to_date:to_date}

                },

                columns: [

                    {

                        data:'id',

                        name:'id'

                    },

                    {

                        data:'name',

                        name:'name'

                    },

                    {

                        data:'email',

                        name:'email'

                    },

                    {

                        data:'created_at',

                        name:'created_at'

                    }

                ]

            });

        }


        $('#filter').click(function(){

            var from_date = $('#from_date').val();

            var to_date = $('#to_date').val();


            if(from_date != '' &&  to_date != ''){

                $('#order_table').DataTable().destroy();

                load_data(from_date, to_date);

            } else{

                alert('Both Date is required');

            }


        });


        $('#refresh').click(function(){

            $('#from_date').val('');

            $('#to_date').val('');

            $('#order_table').DataTable().destroy();

            load_data();

        });

    });

</script>

</body>

</html>