
<div id="aside" class="app-aside fade nav-dropdown">
  <!-- fluid app aside -->
  <div class="navside dk" data-layout="column">
    <div class="navbar no-radius">
      <!-- brand -->
      <a href="index.html" class="navbar-brand">
        <img src="system/images/icon/redbox.png" alt="." class="hide">
        <span class="hidden-folded inline text-logo">REDBOX</span>
      </a>
      <!-- / brand -->
    </div>
    <div data-flex class="hide-scroll">
      <nav class="scroll nav-stacked nav-stacked-rounded nav-color">
        <div class="profile-nav">
          <a><img src="system/images/icon/redbox.png"></a>
        </div>
        <ul class="nav" data-ui-nav>
          <li class="nav-header hidden-folded">
            <span class="text-xs">Main</span>
          </li>
          <li>
            <a href=" {{ route('system.dashboard') }}" title="dashboard">
              <span class="nav-icon">
                <img src="system/images/icon-nav/dashboard.png" width="70%">
              </span>
              <span class="nav-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a>
              <span class="nav-caret">
                <i class="fa fa-caret-down"></i>
              </span>
              <span class="nav-icon">
                <img src="system/images/icon-nav/user.png" width="70%">
              </span>
              <span class="nav-text">Member</span>
            </a>
            <ul class="nav-sub">
              <li>
                <a href="{{ route('system.user.getList') }}" >
                  <span class="nav-text"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Member List</span>
                </a>
              </li>
              @if(Session('user')->User_Level == 1)
              <li>
                <a href="{{route('system.user.getTree')}}" >
                  <span class="nav-text"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Member Tree</span>
                </a>
              </li>
              @endif
            </ul>
          </li>
          {{--<li>
            <a href="{{ route('system.getInvestment') }}" title="Investment">
              <span class="nav-icon">
                <img src="system/images/icon-nav/investment.png" width="70%">
              </span>
              <span class="nav-text">Investment</span>
            </a>
          </li>--}}
          <li>
            <a href="{{ route('system.wallet') }}" title="Investment">
              <span class="nav-icon">
                <img src="system/images/icon-nav/wallet.png" width="70%">
              </span>
              <span class="nav-text">Wallet</span>
            </a>
          </li>
          {{--<li>
            <a href="{{ route('system.getSmartContract') }}" title="Smart">
              <span class="nav-icon">
                <img src="system/images/icon-nav/contract.png" width="70%">
              </span>
              <span class="nav-text">Smart Contract</span>
            </a>
          </li>--}}

          <li>
            <a href="{{ route('system.getTrade') }}" title="Trade">
              <span class="nav-icon">
                <img src="system/images/icon-nav/trade.png" width="70%">
              </span>
              <span class="nav-text">Trade (ITO)</span>
            </a>
          </li>
          <li>
            <a href="https://redboxibet.com/" title="Redbox Ibet">
              <span class="nav-icon">
                <i class="fa fa-gamepad" style="font-size: 20px;"></i>
              </span>
              <span class="nav-text">Redbox Ibet</span>
            </a>
          </li>

          
          <li>
            <a href="{{ route('Ticket') }}" title="Ticket">
              <span class="nav-icon">
                <img src="system/images/icon-nav/ticket.png" width="70%">
              </span>
              <span class="nav-text">Ticket</span>
            </a>
          </li>
          <li>
            <a>
              <span class="nav-caret">
                <i class="fa fa-caret-down"></i>
              </span>
              <span class="nav-icon">
                <img src="system/images/icon-nav/history.png" width="70%">
              </span>
              <span class="nav-text">History</span>
            </a>
            <ul class="nav-sub">
              <li>
                <a href="{{ route('system.history.getHistoryWallet') }}" >
                  <span class="nav-text"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Wallet</span>
                </a>
              </li>
              <li>
                <a href="{{ route('system.history.getHistoryCommission') }}" >
                  <span class="nav-text"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Commission</span>
                </a>
              </li>
<!--
              <li>
                <a href="{{ route('system.history.getHistoryInvestment') }}" >
                  <span class="nav-text"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Investment</span>
                </a>
              </li>
-->
            </ul>
          </li>

		  @if(Session('user')->User_Level == 1 || Session('user')->User_Level == 2 || Session('user')->User_Level == 3)
          <li class="nav-header hidden-folded m-t">
            <span class="text-xs">Admin</span>
          </li>
          <li>
            <a href="{{ route('system.admin.getInvestment') }}" title="Investment">
              <span class="nav-icon">
                <img src="system/images/icon-nav/investment.png" width="70%">
              </span>
              <span class="nav-text">Investment</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getWallet') }}" title="Wallet">
              <span class="nav-icon">
                <img src="system/images/icon-nav/wallet.png" width="70%">
              </span>
              <span class="nav-text">Wallet</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getStatistical') }}" title="Wallet">
              <span class="nav-icon">
                <img src="system/images/icon-nav/wallet.png" width="70%">
              </span>
              <span class="nav-text">Statistical</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getPriceToken') }}" title="Wallet">
              <span class="nav-icon">
                <img src="system/images/icon-nav/wallet.png" width="70%">
              </span>
              <span class="nav-text">Price Token</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getMember') }}" title="Member">
              <span class="nav-icon">
                <img src="system/images/icon-nav/user.png" width="70%">
              </span>
              <span class="nav-text">Member</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getWithdraw') }}" title="Withdraw">
              <span class="nav-icon">
                <img src="system/images/icon-nav/withdraw.png" width="70%">
              </span>
              <span class="nav-text">Withdraw</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getProfile') }}" title="Profile">
              <span class="nav-icon">
                <img src="system/images/icon-nav/user.png" width="70%">
              </span>
              <span class="nav-text">Profile</span>
            </a>
          </li>
          <li>
            <a href="{{ route('getTicketAdmin') }}" title="Ticket">
              <span class="nav-icon">
                <img src="system/images/icon-nav/ticket.png" width="70%">
              </span>
              <span class="nav-text">Ticket</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getLogMail') }}" title="Ticket">
              <span class="nav-icon">
                <img src="system/images/icon-nav/ticket.png" width="70%">
              </span>
              <span class="nav-text">Log Mail</span>
            </a>
          </li>
          <li>
            <a href="{{ route('system.admin.getNotificationImage') }}" title="Withdraw">
              <span class="nav-icon">
                <img src="system/images/icon-nav/withdraw.png" width="70%">
              </span>
              <span class="nav-text">Up Notification</span>
            </a>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </div>
</div>
<div id="content" class="app-content box-shadow-z2 bg pjax-container" role="main">
  <canvas class="canvasBG"></canvas>
  <canvas class="canvasBG"></canvas>
  <div class="app-header">
    <div class="navbar navbar-pd" data-pjax>
      <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
        <i class="ion-navicon"></i>
      </a>
      <div class="navbar-item pull-left h5 border-aside" id="pageTitle"><span>@yield('title')</span></div>
      <!-- nabar right -->
      <ul class="nav navbar-nav pull-right">
        <li class="nav-item dropdown">
          <a class="nav-link clear" data-toggle="dropdown">
            <span class="avatar w-32">
              <img src="system/images/icon/RedUser.png" class="w-full rounded" alt="...">
            </span>
          </a>
          <div class="dropdown-menu w dropdown-menu-scale pull-right">
            <a class="dropdown-item" href="javascript:void(0)">
              User ID: {{Session('user')->User_ID}}
            </a>
            <a class="dropdown-item" href="{{ route('system.getProfile') }}">
              <i class="fa fa-user"></i> Profile
            </a>
            <a class="dropdown-item" href="{{route('getLogout')}}">
              <i class="fa fa-sign-out"></i> Sign out
            </a>
          </div>
        </li>
      </ul>
      <!-- / navbar right -->
    </div>
  </div>
