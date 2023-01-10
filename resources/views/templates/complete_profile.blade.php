 @if(empty(Auth::user()->practice_number))
<div style="background: #1E78A9;"  class="mt-5 alert alert-dismissible fade show" role="alert" >
    <div class="container-fluid welcome-message" style="background: #1E78A9;">
           
          <div class="row">

             <div class="d-lg-flex justify-content-between align-items-center">
              <div class="pr-5 image-border"><img src="https://www.bootstrapdash.com/demo/wagondash/template/images/dashboard/welcome.png" alt="welcome"></div>
               <div class="pl-4">
                <h2 class="text-white font-weight-bold mb-3">Welcome to Medinformer Patient Information Sharing portal.</h2>
                <p class="pb-0 mb-1">Congratulations! Your account has been setup and you are able to customise your profile now.  

</p>
                <p>Customising your profile only takes a few seconds.</p>
              </div>
              <div class="pl-4">
                <button type="button" class="btn btn-primary" id="skip-mesages" type="button" class="close" data-dismiss="alert" aria-label="Close">Dismiss</button>
                <button type="button" class="btn btn-success ml-lg-0 ml-xl-2 ml-2 ml-l mt-lg-2 mt-xl-0"><a href="/user/profile/{{ Auth::user()->id }}" style="color: #fff !important;">Customise Profile</a></button>
              </div>
            </div>

          </div>

      


    </div>




</div>
@endif