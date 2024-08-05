<div class="row border-bottom">
    <nav class="navbar navbar-static" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome {{Auth::user()->employee_name}} (YM TERAS PORTAL).</span>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" id="see-noti">
                    <i class="fa fa-bell"></i>  <span class="label label-warning notiNo" style="display: none"></span>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    
                </ul>
            </li>
            
            <li>
                <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>
    </nav>
</div>

