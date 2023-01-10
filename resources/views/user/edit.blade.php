@extends('layouts.app')

<style type="text/css">
  .card {
  border: 0px;
  margin-bottom: 30px;
  border-radius: 5px;
  -webkit-box-shadow: 0px 1.25rem 1.5625rem #fff;
  box-shadow: 0px 1.25rem 1.5625rem #fff;
  background: #fff;
}
</style>


@section('content')
<div class="container-fluid">
 
<div class="row mt-5">
        <div class="col-xxl-12 col-xl-12">
          <!-- <div class="page-title mt-5">
            <h4>Profile</h4>
          </div> -->
<div class="col-xxl-12 mt-3 mb-3">
                                    @if(Session::has('success'))

                        <div class="alert alert-success">

                            {{ Session::get('success') }}

                            @php

                                Session::forget('success');

                            @endphp

                        </div>

                        @endif
                                </div>




  


          <div class="cardd">
            <div class="card-header">
              <div class="settings-menu active">
                <a href="#" class="active">Personal Information</a>
                
            </div>
             <div class="pull-right">
                <a class="btn btn-primary btn-block" href="{{ route('home') }}"> View Brochures </a>
            </div>
            </div>
              <div class="row mt-5">
               <div class="col-xxl-3">
                <div class="card welcome-profile">
                  <div class="card-body">
                     @if(auth::user()->image)
                  <img class="me-3 rounded-circle me-0 me-sm-3" src="{{asset('/folder/images/'.Auth::user()->image)}}" width="60" height="60"
                />
              @endif
                    <h4>Welcome, {{ $user->name }}!</h4>
                    <p>
                      Looks like you are not verified yet. Verify yourself to use the
                      full potential of Medinformer.
                    </p>

                    <ul>
                      
                      <li>
                        <a href="#">
                          
                          Verify Profile
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

                                    <h4 class="card-title">Your Profile Status</h4>

                   <div class="progress  mt-3" >
          <div class="progress-bar wow fadeInLeft" data-wow-duration="0.7s" data-wow-delay=".5s" role="progressbar" style="width: 100%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="40" style="background-color: #fff !important; color: #000 !important"><span class="percent-label">40%</span></div>



    </div>


@if(Auth::user()->is_admin == 1)

<div class="carddd mt-5" style="background: #fff; padding: 10px;">
                                        <div class="card-header px-0">
                                            <h4 class="card-title">Verify User  </h4>
                                        </div>
                                        <div class="card-body px-0">
         



        <form action="{{ route('user.update-practice',$user->id) }}" method="POST" class="personal_validate" enctype="multipart/form-data">
        @csrf
        @method('PUT') 

                                            <div class="row">
                                              
                                            
                                                <div class="col-12 mb-3">
                                                    
                                          <label class="form-check-label mb-3" for="s2">Make {{ $user->name }} an adminstrator</label>



                                        <select class ="form-control" id="is_admin" name="is_admin">
      <option value="">Select</option>
      <option {{ $user->is_admin == '0' ? 'selected':'' }}>0</option>
      <option {{ $user->is_admin == '1' ? 'selected':'' }}>1</option>
     
 </select>



                       
                                                  </div>
                                                   <div class="col-12 mb-3">
                                                        
                                                        <label class="form-check-label mb-3" for="s2">Approve {{ $user->name }} as a Practitioner.</label>

                                                           <select class ="form-control" id="is_verified" name="is_verified">
      <option value="">Select</option>
      <option {{ $user->is_verified == '0' ? 'selected':'' }}>0</option>
      <option {{ $user->is_verified == '1' ? 'selected':'' }}>1</option>
     
 </select>

                                                
                                                </div>

                                                <div class="col-12">
                                                    <button class="btn btn-success">Save</button>
                                                </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>

@endif

               </div>
                <div class="col-xxl-9">
                  <div class="cardd">
                 
                    <div class="card-body">

<div class="row">
               
                
                <div class="col-xxl-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Personal Information</h4>
                    </div>
                    <div class="card-body">
 <form action="{{ route('users.update',$user->id) }}" method="POST" class="personal_validate" enctype="multipart/form-data">
        @csrf
        @method('PUT')                        <div class="row g-4">

                          <div class="col-xxl-12">
                            <div class="d-flex align-items-center">

                                @if(auth::user()->image)
                              <img class="me-3 rounded-circle me-0 me-sm-3" src="{{asset('/folder/images/'.Auth::user()->image)}}" alt="" width="55" height="55">
                              @endif
                              <div class="media-body">
                                <h4 class="mb-0">{{ $user->surname }}</h4>
                                <p class="mb-0">Max file size is 20mb</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-xxl-12">
                            <div class="form-file">
                        <input type="file" name="image" required>
                             
                            </div>


                             


                          </div>


                          <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="{{ $user->name }}" name="name" value="{{ $user->name }}">
                          </div>

                          <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Surname</label>
                            <input type="text" class="form-control" placeholder="{{ $user->surname }}" name="surname" value="{{ $user->surname }}">
                          </div>

                          <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Email</label>
                            <div class="fx-relay-email-input-wrapper"><input type="email" class="form-control" placeholder="{{ $user->email }}" name="email" value="" disabled style="padding-right: 52px;"><div class="fx-relay-icon" style="top: 0px; bottom: 0px;"></div></div>
                          </div>

                          <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" placeholder="{{ $user->phone_number }}" name="phone_number" value="{{ $user->phone_number }}">
                          </div>

                          <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Whatsapp Number</label>
                            <input type="text" class="form-control" placeholder="{{ $user->whatsapp_number }}" name="whatsapp_number" value="{{ $user->whatsapp_number }}">
                          </div>


                          <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">HCP Type (DR, Nurse)</label>
                            <input type="text" class="form-control" placeholder="{{ $user->type }}" name="type" value="{{ $user->type }}">
                          </div>
                           <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Practice Number</label>
                            <input type="text" class="form-control" placeholder="{{ $user->practice_number }}" name="practice_number" value="{{ $user->practice_number }}" >
                          </div>
                         <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <label class="form-label">Company & Branch Name</label>
                            <input type="text" class="form-control"  placeholder="{{ $user->company }}" name="company" value="{{ $user->company }}">
                          </div>



                          
                       

                          
                        </div>



                    </div>

                    <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Email Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                          <div class="col-lg-12">
                            <label class="form-label">Salutation</label>
                            <input type="text" class="form-control" placeholder="DR" name="fullname" value="{{ $user->salutation }}">
                          </div>
                         

                          <div class="col-lg-12">
                          <label class="form-label" class="mb-5">Email Message</label>

                              <textarea class="form-control" id="exampleFormControlTextarea1" name="email_message" rows="3" placeholder="Thank you for visiting {{ $user->name }} , click on the below link to view an online brochure that we thought you may find helpfuls.

Regards
{{ $user->name }} 
                                " value="Thank you for visiting {{ $user->name }} , click on the below link to view an online brochure that we thought you may find helpfuls.

Regards
{{ $user->name }} "></textarea>
                          </div>
                         
                          <div class="col-lg-12 ">
                            <label class="form-label" class="mb-5">Image Signature</label>
                              </br>
                            <input type="file" name="email_signature" >
                          </div>

                          <div class="col-12">
                            <button class="btn btn-success pl-5 pr-5 waves-effect">
                              Save Changes
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

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