@extends('System.Layouts.Master')
@section('title')
Exchange
@endsection
@section('css')
@endsection
@section('content')
<div class="app-body">
    <div class="col-lg-12 col-xl-12">
      <div class="row">
        <div class="col-sm-12 col-md-4 ">
          <div class="box">
            <div class="item">
              <div class="item-bg light h6">
                </div>
                    <div class="p-a p-t-sm pos-rlt">
                    <img src="system/images/icon/eth.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                </div>
            </div>
            <div class="p-a-md bg-logo">
              <div class="m-t">
                  <table class="table m-a-0 table-box">
                    <tbody>
                      <tr class="border-bt">
                        <td class="text-danger item-title">Ethereum</td>
                        <td id="ethBalance">N / A</td>
                      </tr>
                      <tr>
                        <td>$ {{$rate['ETH']+0}}</td>
                        <td class="text-danger item-title"></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="box">
            <div class="item">
              <div class="item-bg light h6">
                </div>
                    <div class="p-a p-t-sm pos-rlt">
                    <img src="system/images/icon/redbox.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                </div>
            </div>
            <div class="p-a-md bg-logo">
              <div class="m-t">
                  <table class="table m-a-0 table-box">
                    <tbody>
                      <tr class="border-bt">
                        <td class="text-danger item-title">RedBox</td>
                        <td id="RBDWallet">N / A</td>
                      </tr>
                      <tr>
                        <td>$ {{$rate['RBD']+0}}</td>
                        <td class="text-danger item-title"></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="box">
            <div class="item">
              <div class="item-bg light h6">
                </div>
                    <div class="p-a p-t-sm pos-rlt">
                    <img src="system/images/icon/usd.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                </div>
            </div>
            <div class="p-a-md bg-logo">
              <div class="m-t">
                  <table class="table m-a-0 table-box">
                    <tbody>
                      <tr class="border-bt">
                        <td class="text-warn item-title">USD</td>
                        <td>$ {{$balance->USD+0}}</td>
                      </tr>
                      <tr>
                        <td>$ 1</td>
                        <td class="text-warn item-title"></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
        
      <div class="col-md-4 offset-md-2">
        <div class="box">
          <div class="box-header">
            <div class="pull-left">
              <h2><i class="fa fa-usd" aria-hidden="true"></i> USDE - RBD</h2>
            </div>
            <h2 class="text-center text-warning" style="opacity: 0;">1</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <div class="row m-b p-a USDE-RBD">
              <label for="single-prepend-text">Price</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" class="form-control" value="{{$rate['RBD']}}" placeholder="Username">
              </div>
              <div class="form-group">
                <label>Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Amount USDM" required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-outline success exchange" data-coin="USDE-RBD"><i class="fa fa-send-o" aria-hidden="true"></i> Exchange</button>
              </div>
            </div>
            </div>
          </div>
        </div>
      <div class="col-md-4">
        <div class="box">
          <div class="box-header">
            <div class="pull-left">
              <h2><i class="fa fa-usd" aria-hidden="true"></i> RBD - ETH</h2>
            </div>
            
            <h2 class="text-center text-warning" style="opacity: 0;">1</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <div class="row m-b p-a RBD-ETH">
              <label for="single-prepend-text">Price</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" class="form-control" value="{{$rate['ETH']}}" placeholder="Username">
              </div>
              <div class="form-group">
                <label>Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Amount RBD" required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-outline success exchange" data-coin="RBD-ETH"><i class="fa fa-send-o" aria-hidden="true"></i> Exchange</button>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
          <!-- ############ PAGE START-->
          <div class="row-col">
            <div class="col-lg b-r">
              <div class="padding padding-big">
                <div class="row">

                    <div class="col-md-12">
                        <div class="box">
                          <div class="box-header">
                              <h2><i class="fa fa-history"></i> History</h2>
                          </div>
                          <div class="box-body bg-logo">
                            <div>
                              <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="10">
			                    <thead>
			                      <tr>
			                        <th data-toggle="true">
			                          ID
			                        </th>
			                        <th>
			                          DEPOSIT AMOUNT
			                        </th>
			                        <th data-hide="phone,tablet">
			                          MONEY ACTION
			                        </th>
			                        <th data-hide="phone">
			                          FEE
			                        </th>
			                        <th data-hide="phone">
			                          EXCHANGE RATE
			                        </th>
			                        <th data-hide="phone">
			                          Date Time
			                        </th>
			                        <th data-hide="phone">
			                          COMMENT
			                        </th>
			                      </tr>
			                    </thead>
			                    <tbody>
			                    @foreach($history as $item)
			                        <tr>
			                            <td>{{$item['Money_ID']}}</td>
			                            <td>{{number_format($item['Money_USDT'], 2)}}</td>
			                            <td>{{$item['MoneyAction_Name']}}</td>
			                            <td>{{number_format($item['Money_USDTFee'], 2)}}</td>
			                            <td>{{number_format($item['Money_Rate'], 3)}}</td>
			                            <td>{{date('Y-m-d H:i:s', $item['Money_Time'])}}</td>
			                            <td>{{$item['Money_Comment']}}</td>
			                        </tr>
			                    @endforeach
			                    </tbody>
			                    <tfoot class="hide-if-no-paging">
			                    <tr>
			                      <td colspan="7" class="text-center"><ul class="pagination"></ul></td>
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
          <div class="modal fade inactive" id="chat" data-backdrop="false">
            <div class="modal-right w-xxl dark-white b-l">
              <div class="row-col">
                <a data-dismiss="modal" class="pull-right text-muted text-lg p-a-sm m-r-sm">&times;</a>
                <div class="p-a b-b">
                  <span class="h5">Chat</span>
                </div>
                <div class="row-row light">
                  <div class="row-body scrollable hover">
                    <div class="row-inner">
                      <div class="p-a-md">
                        <div class="m-b">
                          <a href="#" class="pull-left w-40 m-r-sm"><img src="images/a2.jpg" alt="..." class="w-full img-circle"></a>
                          <div class="clear">
                            <div class="p-a p-y-sm dark-white inline r">
                              Hi John, What's up...
                            </div>
                            <div class="text-muted text-xs m-t-xs"><i class="fa fa-ok text-success"></i> 2 minutes ago</div>
                          </div>
                        </div>
                        <div class="m-b">
                          <a href="#" class="pull-right w-40 m-l-sm"><img src="images/a3.jpg" class="w-full img-circle" alt="..."></a>
                          <div class="clear text-right">
                            <div class="p-a p-y-sm success inline text-left r">
                              Lorem ipsum dolor soe rooke..
                            </div>
                            <div class="text-muted text-xs m-t-xs">1 minutes ago</div>
                          </div>
                        </div>
                        <div class="m-b">
                          <a href="#" class="pull-left w-40 m-r-sm"><img src="images/a2.jpg" alt="..." class="w-full img-circle"></a>
                          <div class="clear">
                            <div class="p-a p-y-sm dark-white inline r">
                              Good!
                            </div>
                            <div class="text-muted text-xs m-t-xs"><i class="fa fa-ok text-success"></i> 5 seconds ago</div>
                          </div>
                        </div>
                        <div class="m-b">
                          <a href="#" class="pull-right w-40 m-l-sm"><img src="images/a3.jpg" class="w-full img-circle" alt="..."></a>
                          <div class="clear text-right">
                            <div class="p-a p-y-sm success inline text-left r">
                              Dlor soe isep..
                            </div>
                            <div class="text-muted text-xs m-t-xs">Just now</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-a b-t">
                  <form>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Say something">
                      <span class="input-group-btn">
                        <button class="btn white b-a no-shadow" type="button">SEND</button>
                      </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- ############ PAGE END-->
        </div>
@endsection
@section('script')
  <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
  <script src="../js/custom.js?v={{time()}}"></script>
  <script>
	  rateCoin = {'ETH': {{ $rate['ETH'] }}, 'RBD': {{ $rate['RBD'] }}, 'USDT': 1};
  </script>
@endsection