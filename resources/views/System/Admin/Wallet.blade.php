@extends('System.Layouts.Master')
@section('title')
Admin Wallet
@endsection
@section('css')
@endsection
@section('content')
<div class="app-body">
  <!-- ############ PAGE START-->
  <div class="row-col">
    <div class="col-lg b-r">
      <div class="padding padding-big">
        <div class="row">

          <div class="col-lg-6 col-md-6 col-xs-12 mx-auto">
            <div class="box">
              <div class="box-header">
                <h2><i class="fa fa-usd" aria-hidden="true"></i> Deposit</h2>
              </div>
              <div class="box-body bg-logo">
                <div class="row m-b p-a">
                  <form method="post" action="{{route('system.admin.postDepositAdmin')}}">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-users"></i> User ID or User Name</label>
                      <input type="text" class="form-control" name="user" id="exampleInputEmail1"
                        placeholder="Enter User ID">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-money"></i> Amount</label>
                      <input type="number" step="any" name="amount" class="form-control"
                        placeholder="Enter amount coin">
                    </div>
                    <label><i class="fa fa-hand-o-down"></i> Currency</label>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <select class="form-control c-select" name="coin">
                          <option value="5">USD</option>
                          <option value="2">ETH</option>
                          <option value="8" selected="">RBD</option>
                        </select>
                      </div>
                    </div>

                    <div class="m-t-43">
                      <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                        Deposit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-12 mx-auto">
            <div class="box">
              <div class="box-header">
                <h2><i class="fa fa-usd" aria-hidden="true"></i> Investment</h2>
              </div>
              <div class="box-body bg-logo">
                <div class="row m-b p-a">
                  <form method="post" action="{{route('system.admin.postInvestAdmin')}}">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-users"></i> User ID or User Name</label>
                      <input type="text" class="form-control" name="user" id="exampleInputEmail1"
                        placeholder="Enter User ID">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"><i class="fa fa-money"></i> Amount</label>
                      <input type="number" step="any" name="amount" class="form-control"
                        placeholder="Enter amount coin">
                    </div>
                    <label><i class="fa fa-hand-o-down"></i> Currency</label>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <select class="form-control c-select" name="coin">
                          <option value="5" selected="">USD</option>
                          <option value="2">ETH</option>
                          <option value="8">RBD</option>
                        </select>
                      </div>
                    </div>

                    <div class="m-t-43">
                      <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                        Invest</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <form method="get" action="{{route('system.admin.getWallet')}}">
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-12">
                  <div class="box">
                    <div class="box-header">
                      <h2><i class="fa fa-usd" aria-hidden="true"></i> Wallet</h2>
                    </div>
                    <div class="box-divider m-a-0"></div>
                    <div class="box-body bg-logo">
                      <div class="row m-b p-a">
                        <div class="col-md-6">
                          <label for="single-prepend-text">User ID</label>
                          <div class="input-group m-b">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="user_id" class="form-control" placeholder="Enter User ID">
                          </div>
                          <label for="single-prepend-text">User Email</label>
                          <div class="input-group m-b">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email">
                          </div>
                          <div class="form-group">
                            <label for="single-prepend-text">Action</label>
                            <div class="input-group select2-bootstrap-prepend">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                                  <span class="fa fa-caret-down"></span>
                                </button>
                              </span>
                              <select id="single-prepend-text" name="action" class="form-control select2"
                                data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                                <option value="" selected>---select---</option>
                                @foreach($action as $a)
                                <option value="{{$a->MoneyAction_ID}}">{{$a->MoneyAction_Name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="single-prepend-text">Status</label>
                            <div class="input-group select2-bootstrap-prepend">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                                  <span class="fa fa-caret-down"></span>
                                </button>
                              </span>
                              <select id="single-prepend-text" name="status" class="form-control select2"
                                data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                                <option value="" selected>---selected---</option>
                                <option value="0">Pending</option>
                                <option value="1">Confirmed</option>
                                <option value="-1">Error</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="single-prepend-text">From</label>
                          <div class="form-group">
                            <div class='input-group date' data-ui-jp="datetimepicker" data-ui-options="{
                            format: 'YYYY-MM-DD',
                            icons: {
                            time: 'fa fa-clock-o',
                            date: 'fa fa-calendar',
                            up: 'fa fa-chevron-up',
                            down: 'fa fa-chevron-down',
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                            }
                            }">
                              <input type='text' name="datefrom" class="form-control" />
                              <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                              </span>
                            </div>
                          </div>
                          <label for="single-prepend-text">To</label>
                          <div class="form-group">
                            <div class='input-group date' data-ui-jp="datetimepicker" data-ui-options="{
                            format: 'YYYY-MM-DD',
                            icons: {
                            time: 'fa fa-clock-o',
                            date: 'fa fa-calendar',
                            up: 'fa fa-chevron-up',
                            down: 'fa fa-chevron-down',
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                            }
                            }">
                              <input type='text' name="dateto" class="form-control" />
                              <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                              </span>
                            </div>
                          </div>

                          <label for="single-prepend-text">Check To Export</label>
                          <div class="input-group m-b pull-left">
                            <input type="checkbox" class="form-control" name="export" value="1"
                              style="width: 26px; height: 26px;">
                          </div>
                          <div class="pull-left">
                            <div class="btn-groups">
                              <button class="btn btn-primary info" type="submit"><i class="fa fa-search"
                                  aria-hidden="true"></i>
                                Search</button>
                              <button class="btn btn-default success" type="submit" name="export" value="1"><i
                                  class="fa fa-print" aria-hidden="true">Export</i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="col-md-12">
            <div class="box">
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-history"></i> History Wallet</h2>
                </div>
                <div class="pull-right">
                  <h2>Total: $123456</h2>
                </div>
              </div>
              <div class="box-body bg-logo">
                <div class="p-a-sm">
                  Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r" />
                </div>
                <div class="table-responsive">
                  <table class="table m-b-none" data-page-size="5">
                    <thead>
                      <tr>
                        <th data-toggle="true">
                          ID
                        </th>
                        <th data-hide="phone">
                          LEVEL
                        </th>
                        <th data-hide="phone">
                          USER ID
                        </th>
                        <th data-hide="phone">
                          BINARY TREE
                        </th>
                        <th data-hide="phone">
                          SUN TREE
                        </th>
                        <th data-hide="phone">
                          AMOUNT
                        </th>

                        <th data-hide="phone">
                          AMOUNT COIN
                        </th>
                        <th data-hide="phone">
                          FEE
                        </th>
                        <th data-hide="phone">
                          RATE
                        </th>
                        <th data-hide="phone">
                          CURRENCY
                        </th>
                        <th data-hide="phone">
                          ACTION
                        </th>
                        <th data-hide="phone">
                          COMMENT
                        </th>
                        <th data-hide="phone">
                          TIME
                        </th>
                        <th data-hide="phone">
                          STATUS
                        </th>
                        <th data-hide="phone">
                          ACTION
                        </th>
                        <th data-hide="phone">
                          HASH / ADDRESS
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($walletList as $item)
                      <tr>
                        @if($item->User_Level == 0)
                        <td>{{$item->Money_ID}}</td>
                        @elseif($item->User_Level == 1)
                        <td class="bg-success">{{$item->Money_ID}}</td>
                        @elseif($item->User_Level == 2)
                        <td class="bg-info">{{$item->Money_ID}}</td>
                        @else
                        <td class="bg-warning">{{$item->Money_ID}}</td>
                        @endif
                        <td>{{$level[$item->User_Level]}}</td>
                        <td>{{$item->Money_User}}</td>
                        <td width="200px">
                          <div style="overflow:auto;width:300px!important;height:60px">
                            {{ str_replace(',',', ', $item->User_Tree) }}
                          </div>
                        </td>
                        <td width="200px">
                          <div style="overflow:auto;width:300px!important;height:60px">
                            {{ str_replace(',',', ', $item->User_SunTree) }}
                          </div>
                        </td>
                        <td>
                          {{number_format($item->Currency_Symbol != 'DBC' ? $item->Money_USDT : $item->Money_USDT*$item->Money_Rate,2)}}
                        </td>
                        <td>
                          {{number_format($item->Currency_Symbol == 'DBC' ? $item->Money_USDT : $item->Money_CurrentAmount,2)}}
                        </td>
                        <!--                 <td>{{number_format($item->Money_USDT*$item->Money_Rate, 2)}}</td> -->
                        <td>{{number_format($item->Money_USDTFee, 2)}}</td>
                        <td>{{number_format($item->Money_Rate, 3)}}</td>
                        <td>{{$item->Currency_Symbol}}</td>
                        <td>{{$item->MoneyAction_Name}}</td>
                        <td>{{$item->Money_Comment}}</td>
                        <td>{{date('Y-m-d H:i:s',$item->Money_Time)}}</td>
                        <td>
                          @if($item->Money_MoneyStatus == 1)
                          @if($item->Money_MoneyAction == 2 && $item->Money_Confirm == 0)
                          <span class="badge badge-warning">Pending</span>

                          @else
                          <span class="badge badge-success">Confirmed</span>
                          @endif
                          @else
                          <span class="badge badge-warning">Error</span>
                          @endif
                        </td>
                        <td>
                          <a class="btn btn-rounded btn-primary btn-xs"
                            href="{{ route('system.admin.getWalletDetail', $item->Money_ID) }}">Detail</a>
                        </td>
                        <td>{{$item->Money_Address}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                      <tr>
                        <td colspan="12" class="text-center">
                          {{$walletList->appends(request()->input())->links()}}
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ############ PAGE END-->
</div>
@endsection
@section('script')
@endsection