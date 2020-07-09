<div class="page-header-inner ">
    <div class="page-logo">
        <a href="index.html">
            <!-- <h4 class="logo-default">IWS</h4> -->
            <img src="{{ asset('assets/global/img/logo.png') }}" alt="" width="100" class="logo-default" />
        </a>
        <div class="menu-toggler sidebar-toggler">
           
        </div>
    </div>
    
    <a class="logout-on-mobile hidden-md hidden-lg" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-key"></i> Logout</a>
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

    <div class="page-top hidden-xs hidden-sm">
        <!-- <form class="search-form" action="page_general_search_2.html" method="GET">
            <div class="input-group">
                <input type="text" class="form-control input-sm" placeholder="Search..." name="query">
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit">
                        <i class="icon-magnifier"></i>
                    </a>
                </span>
            </div>
        </form> -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="separator hide"></li>
                <li class="separator hide"> </li>
                <li class="separator hide"> </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-key"></i> Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

    </div>

</div>