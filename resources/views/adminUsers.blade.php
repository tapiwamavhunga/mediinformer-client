@extends('layouts.app')

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>
    .bt-content {
  font-size: 14px !important;
}

</style>
@section('content')


   <div class="content-body">
          <div class="container-fluid-max">

          <div class="col-xxl-12">
                    <div class="cards">
                        

                        <div class="card-header">
              <h4 class="card-title">Users</h4>
              <a href="/export_users" id="export" class="btn btn-success btn-sm" >Export</a>
            </div>


                        


                        <div class="card-body">
                            <div class="table-responsive">
                         <div class="col-xxl-12">
                    <div class="cards">
                      
                            <div class="table-responsive">
                                <table class="table table-striped responsive-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Practice Number</th>
                                            <th>Phone Number </th>
                                             <th>WhatsApp Number </th>
                                            <th>Verified </th>
                                            <th>Is Admin </th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($users as $user)
                                          <tr>
                                            <td data-th="ID"><span class="bt-content">{{$user->id}}</span></td>
                                            <td class="coin-name" data-th="Type"><span class="bt-content">
                                                
                                                <span>{{$user->name}}</span>
                                            </span></td>
                                            <td data-th="Amount"><span class="bt-content">
                                                {{$user->email}}
                                            </span></td>
                                            <td data-th="Fee"><span class="bt-content">
                                                Medinformer
                                            </span></td>
                                            <td data-th="Date"><span class="bt-content">
                                                {{$user->practice_number}}
                                            </span></td>

                                            <td data-th="Date"><span class="bt-content">
                                                {{$user->phone_number}}
                                            </span></td>

                                            <td data-th="Date"><span class="bt-content">
                                                {{$user->whatsapp_number}}
                                            </span></td>


                                            <td data-th="Hash"><span class="bt-content">
                                                <?php if ($user->is_verified == 1) {
                                                   echo "Yes";
                                                }else{
                                                    echo "No";
                                                }?>
                                            </span></td>

                                                  <td data-th="Hash"><span class="bt-content">
                                                <?php if ($user->is_admin == 1) {
                                                   echo "Yes";
                                                }else{
                                                    echo "No";
                                                }?>
                                            </span></td>
                                            

                                            <td data-th="Status">
                <form action="{{ route('users.destroy',$user->id) }}" method="POST">
   
                    <!-- <a  href="{{ route('users.show',$user->id) }}">Show</a> -->
    
                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>


                                        </tr>
                                      @endforeach
                                      
                                        
                                    </tbody>
                                </table>


                            </div>
                                                                                    {{ $users->links() }}


                        </div>

                </div>


                            </div>


                        </div>

                    </div>
                </div>
        </div>


</div>

@endsection


<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.getusers') }}",
        columns: [

            {data: 'id', name: 'id'},

            {data: 'name', name: 'name'},

            {data: 'email', name: 'email'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });

    

  });

</script>
