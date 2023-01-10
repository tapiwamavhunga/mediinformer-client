<div class="header bg-light" style="background: #fff !important;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xxl-12">
        <div class="header-content">
          <div class="header-left">
            <div class="brand-logo">
                <a href="/">
                <img src="{{URL::asset('/images/Cipla_logo.svg_-.png')}}" style="width: 150px; float: left;">
                </a>
            </div>
            <div class="search d-none">
              <form action="#">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search Here"
                  />
                  <span class="input-group-text"
                    ><i class="icofont-search"></i
                  ></span>
                </div>
              </form>
            </div>
          </div>

          @if (Auth::check())
          @if(Auth::user()->is_admin == 0)

          



          <div class="header-right">
            <div class="dark-light-toggle" onclick="themeToggle()">
              <span class="dark"><i class="bi bi-moon"></i></span>
              <span class="light"><i class="bi bi-brightness-high"></i></span>
            </div>
            <div class="notification dropdown">
              <div class="notify-bell" data-toggle="dropdown">
                <span><i class="bi bi-bell"></i></span>
              </div>
              <div class="dropdown-menu dropdown-menu-right notification-list">
                <h4>Notifications</h4>
                <div class="lists">
                  <a href="#" class="">
                    <div class="d-flex align-items-center">
                      <span class="me-3 icon success"
                        ><i class="bi bi-check"></i
                      ></span>
                      <div>
                        <p>Account created successfully</p>
                        <span>2020-11-04 12:00:23</span>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="">
                    <div class="d-flex align-items-center">
                      <span class="me-3 icon fail"
                        ><i class="bi bi-x"></i
                      ></span>
                      <div>
                        <p>2FA verification failed</p>
                        <span>2020-11-04 12:00:23</span>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="">
                    <div class="d-flex align-items-center">
                      <span class="me-3 icon success"
                        ><i class="bi bi-check"></i
                      ></span>
                      <div>
                        <p>Device confirmation completed</p>
                        <span>2020-11-04 12:00:23</span>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="">
                    <div class="d-flex align-items-center">
                      <span class="me-3 icon pending"
                        ><i class="bi bi-exclamation-triangle"></i
                      ></span>
                      <div>
                        <p>Phone verification pending</p>
                        <span>2020-11-04 12:00:23</span>
                      </div>
                    </div>
                  </a>

                  <a href="settings-activity.html"
                    >View All Recquests <i class="icofont-simple-right"></i
                  ></a>
                </div>
              </div>
            </div>

            @endif
            @endif
            @guest

            <ul>
                 @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
            </ul>

            @else
            <div class="profile_log dropdown">
              <div class="user" data-toggle="dropdown">
                <span class="thumb"
                  >
                  @if(auth::user()->image)
                  <img src="{{asset('/folder/images/'.Auth::user()->image)}}" alt=""
                />

              @else
              <img src="{{asset('/folder/images/2.png')}}" alt=""
                />
              @endif
            </span>
                <span class="arrow"><i class="icofont-angle-down"></i></span>
              </div>


              <div class="dropdown-menu dropdown-menu-right">
                <div class="user-email">
                  <div class="user">
                    

              

                    <div class="user-info">
                      <h5>{{ Auth::user()->name }}</h5>
                      <span>{{ Auth::user()->email }}</span>
                    </div>
                  </div>
                </div>

                
                <a href="/user/profile/{{ Auth::user()->id }}" class="dropdown-item">
                  <i class="bi bi-person"></i>Profile
                </a>
                
            <!--     <a href="/reports" class="dropdown-item">
                  <i class="bi bi-gear"></i> Setting
                </a> -->
               
               <a href="/user_reports" class="dropdown-item">
                  <i class="bi bi-gear"></i> Reports
                </a>
               
                

                <a class="dropdown-item logout" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-power"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>


              </div>
            </div>

            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>