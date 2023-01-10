@extends('layouts.app')

@section('content')


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<div class="content-body ">
    <div class="container mt-5 pt-5">
      <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-6">
          <div class="card welcome-profile">
            <div class="card-body">

              @if(auth::user()->image)
                  <img src="{{asset('/folder/images/'.Auth::user()->image)}}" style="width: 60px; height: 60px;" 
                />

                @else
                              <img src="{{asset('/folder/images/'.Auth::user()->image)}}" alt="" />

              @endif


              <h4>Welcome, {{ $user->name }}!</h4>
              <p>
                 Complete your profile in full and provide your practice number for verification.<br> Call 0761883034 for instant verification. 
              </p>

              <ul>
                @if(Auth::user()->is_verified == NULL)
                <li>
                  <a href="/verify-me">
                    
                    Verify account
                  </a>
                </li>
                @endif
                <li>
                  <a href="{{ route('users.edit',$user->id) }}">
                    
                    Click here to complete your profile.
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Reports</h4>
            </div>
            <div class="card-body">
              <div class="app-link">
                <h5>Get Analytics in realtime.</h5>
                <p>
                  You can only view reports once you have been verified. 
                </p>
                <a href="/user_reports" class="btn btn-primary">
                 View your Reports 
                </a>
                <br />
                <div class="mt-3"></div>
                <a href="/" class="btn btn-primary">
                  View Brochures
                  </a>
              </div>
            </div>
          </div>
        </div>
      @include('templates.stats')

      <div class="progress-charts wow move-up mb-5">
                                            <h6 class="title">Profile Completion</h6>
                                            <div class="progress">
                                                <div class="progress-bar wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay=".3s" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"><span class="percent-label">33.3%</span></div>
                                            </div>
                                        </div>


      <div class="col-xxl-12 mb-5">
                    <a  href="/" class="btn btn-success btn-block">View Brochures</a>
      </div>
        <div class="col-xxl-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title ">Profile Summary</h4>
              <a  href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">Edit</a>

            </div>
            <div class="card-body">
              <form class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>USER ID</span>
                    <h4>{{$user->id}}</h4>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>EMAIL ADDRESS</span>
                    <h4>{{$user->email}}</h4>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>Company</span>
                    <h4>Medinformer</h4>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>Practice Number</span>
                    <h4>{{$user->practice_number}}</h4>
                  </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>Phone Number</span>
                    <h4>{{$user->phone_number}}</h4>
                  </div>
                </div>

                 <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>WhatsApp Number</span>
                    <h4>{{$user->whatsapp_number}}</h4>
                  </div>
                </div>

                 <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>TYPE</span>
                    <h4>{{$user->type}}</h4>
                  </div>
                </div>

                 <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>Is_Admin</span>
                    <h4>{{$user->is_admin}}</h4>
                  </div>
                </div>

                 <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>Is Verified</span>
                    <h4>{{$user->is_verified}}</h4>
                  </div>
                </div>

                 <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>Branch</span>
                    <h4>{{$user->company}}</h4>
                  </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                  <div class="user-info">
                    <span>JOINED SINCE</span>
                    <h4>{{$user->created_at}}</h4>
                  </div>
                </div>


                <div class="col-xxl-12">
                  <div class="user-info">
                    <span>Email Signature</span>
                    <h4>{{$user->email_message}}</h4>
                  </div>
                </div>


              </form>
            </div>
          </div>
        </div>

      
      </div>
    </div>
  </div>
@endsection