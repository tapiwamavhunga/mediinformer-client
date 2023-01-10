@extends('layouts.app')


@section('content')

<div class="container-fluid">    

  <div class="card-header">
              <h4 class="card-title">Email Reports</h4>
              <span data-href="/export-csv" id="export" class="btn btn-success btn-sm" onclick="exportTasks (event.target);">Export</span>
            </div>



    <div class="mt-3 row input-daterange">

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

 

    <div class="table-responsive mt-5">

        <table class="table table-bordered table-striped" id="order_table">

            <thead>

                <tr>

                    <th>Transaction ID</th>

                    <th>Sent To</th>

                    <th>Patient Email</th>
                    <th>Sent From</th>
                    <th>Brochure</th>
                    <th>Date</th>

                </tr>

            </thead>

        </table>

    </div>





     <div class="card-header mt-5">
              <h4 class="card-title">SMS Reports</h4>
              <span data-href="/export-csv" id="export" class="btn btn-success btn-sm" onclick="exportTasks (event.target);">Export</span>
            </div>

    <div class="mt-3 row input-daterange">

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



        <div class="table-responsive mt-5 mb-5">

        <table class="table table-bordered table-striped" id="smsrep_table">

            <thead>

                <tr>

                    <th>Transaction ID</th>

                    <th>Sent By</th>

                    <th>Patient Number</th>
                    <th>Brochure</th>
                    <th>Sent From</th>
                    
                    <th>Date</th>

                </tr>

            </thead>

        </table>

    </div>




</div>


@endsection


