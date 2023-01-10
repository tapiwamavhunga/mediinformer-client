@extends('layouts.app')

   

@section('content')

<style type="text/css">
  .relative.z-0.inline-flex.shadow-sm.rounded-md {
  display: none;

}

.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
  margin-top: 20px;
}

</style>

  <div class="content-body">
          <div class="container-fluid-max">

          <div class="col-xxl-12">
                    <div class="cards">
                        

                        <div class="card-header">
              <h4 class="card-title">Verify Practitioners</h4>
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
                                            
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($verify as $very)
                                          <tr>
                                            <td data-th="ID"><span class="bt-content">{{$very->id}}</span></td>
                                            <td class="coin-name" data-th="Type"><span class="bt-content">
                                                
                                                <span>{{$very->name}}</span>
                                            </span></td>
                                            <td data-th="Amount"><span class="bt-content">
                                                {{$very->email}}
                                            </span></td>
                                            <td data-th="Fee"><span class="bt-content">
                                                Medinformer
                                            </span></td>
                                            <td data-th="Date"><span class="bt-content">
                                                {{$very->practice_number}}
                                            </span></td>

                                            <td data-th="Date"><span class="bt-content">
                                                {{$very->phone_number}}
                                            </span></td>

                                            <td data-th="Date"><span class="bt-content">
                                                {{$very->whatsapp_number}}
                                            </span></td>


                                            
                                            

                                            <td data-th="Status">
                <form action="{{ route('users.destroy',$very->id) }}" method="POST">
   
    
                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$very->user_id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                </form>
            </td>


                                        </tr>
                                      @endforeach
                                      
                                        
                                    </tbody>
                                </table>


                            </div>
                                                                                    


                        </div>

                </div>


                            </div>


                        </div>

                    </div>
                </div>
        </div>


</div>      
@endsection