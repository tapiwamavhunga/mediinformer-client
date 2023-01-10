<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tende</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/logoi.png" />
    <!-- Custom Stylesheet -->
     
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet"> 
<script src="https://kit.fontawesome.com/be0233d1e2.js" crossorigin="anonymous"></script>
<style type="text/css">
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap");
    .formfields .formfield input[type="text"], .formfields .formfield input[type="file"], .formfields .formfield input[type="password"], .formfields .formfield textarea, .formfields .formfield select{
        font-family: Poppins !important;
    }

    body {
  margin: 0;
  font-family: "Archivo", sans-serif !important;
  font-size: 13px !important;
  font-weight: 400;
  line-height: 1.5;
  color: #7184ad;
  background-color: #fff;
  -webkit-text-size-adjust: 100%;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

</style>

<style>
        form i {
            margin-left: -30px;
            cursor: pointer;
        }
    </style>


  </head>

  <body class="@@dashboard">


<div id="main-wrapper">
  <div class="authincation section-padding">
    <div class="container h-100">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-xl-5 col-md-6">
          <div class="mini-logo text-center my-4">
            <a href="/"><img src="images/small.png" alt="" /></a>
            <h4 class="card-title mt-5">Welcome to Medinformer Patient Information Sharing portal</h4>
          </div>
          <div class="auth-form card">
            <div class="card-body">
              <form name="myform"
                class="signin_validate row g-3" method="POST" action="{{ route('login') }}">
                @csrf
                 
                            <label for="email" class="col-md-12 col-form-label text-md-start">{{ __('Email Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                       

                        
                            <label for="password" class="col-md-12 col-form-label text-md-start">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                


                            <div class="form-group pass_show"> 
                <input type="password" value="" class="form-control" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> 
            </div> 

  @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        

                        
                            <div class="col-md-12 mt-3 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        

                       
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary  btn-block text-md-middle" style="width: 100%;">
                                    {{ __('Login') }}
                                </button>

                                    <a class="btn btn-link mt-3" href="{{ route('password.request') }}" style="color: #5234C4; text-align: center; font-size: 13px; width: 100%;">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                            </div>

                           
                        
                    </form>
             
            </div>
          </div>
          <div class="privacy-link">
             <p class="mt-3 mb-0 text-center">
                Don't have an account?
                <a class="text-primary" href="/register">Sign up</a>
              </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="js/scripts.js"></script>

<style>
        form i {
            margin-left: -30px;
            cursor: pointer;
        }

        .pass_show{position: relative} 

.pass_show .ptxt { 

position: absolute; 

top: 50%; 

right: 10px; 

z-index: 1; 

color: #f36c01; 

margin-top: -10px; 

cursor: pointer; 

transition: .3s ease all; 

} 

.pass_show .ptxt:hover{color: #333333;} 

    </style>
<script>
    
$(document).ready(function(){
$('.pass_show').append('<span class="ptxt">Show</span>');  
});
  

$(document).on('click','.pass_show .ptxt', function(){ 

$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

});  
    </script>

</body>


<!-- Mirrored from tende.vercel.app/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Feb 2022 06:52:48 GMT -->
</html>
