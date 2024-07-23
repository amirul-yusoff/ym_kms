<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{Auth::user()->employee_name}}</strong>
                            </span>
                            <span class="text-muted text-xs block">
                                {{Auth::user()->employee_code}}
                                <b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{url('member/'.Auth::user()->id)}}">Profile</a></li>
                        <li class="divider"></li>
                        <li>               <form id="sidemenulogoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('sidemenulogoutform').submit();">
                            <i class="nav-icon fas fa-fw fa-sign-out-alt">
        
                            </i>
                            {{ trans('global.logout') }}
                        </a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    SUB
                </div>
            </li>
            @include('partials.sidemenu-items', ['items' => $MyNavBar->roots()])
        </ul>
    </div>
</nav>










