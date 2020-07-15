@extends('System.Layouts.Master')
@section('title')
Investment
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
              <h2><i class="fa fa-usd" aria-hidden="true"></i> Investment ETH</h2>
            </div>
            <h2 class="text-center text-warning" style="opacity: 0;">1</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <div class="row m-b p-a">
              <label for="single-prepend-text">Price</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" class="form-control" value="{{$rate['ETH']}}" placeholder="Username">
              </div>
              {{-- <div class="form-group">
                <label>Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Amount USD" id="amountUSD-ETH" required>
              </div> --}}
              <div class="text-center">
                <button type="button" class="deposit btn btn-outline info send-button" data-id="2" data-coin="ETH"><i
                    class="fa fa-send-o" aria-hidden="true"></i> Join Package</button>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box">
          <div class="box-header">
            <div class="pull-left">
              <h2><i class="fa fa-usd" aria-hidden="true"></i> Investment RBD</h2>
            </div>

            <h2 class="text-center text-warning" style="opacity: 0;">1</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body bg-logo">
            <div class="row m-b p-a">
              <label for="single-prepend-text">Price</label>
              <div class="input-group m-b">
                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                <input type="text" class="form-control" value="{{$rate['RBD']}}" placeholder="Username">
              </div>
              {{-- <div class="form-group">
                <label>Amount</label>
                <input type="number" step="any" class="form-control" placeholder="Amount USD" id="amountUSD-RBD"
                  required>
              </div> --}}
              <div class="text-center">
                <button type="button" id="buy_btn" class="deposit btn btn-outline info send-button" data-id="8" data-coin="RBD"><i
                    class="fa fa-send-o" aria-hidden="true"></i> Join Package</button>
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
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-user"></i> Investment List</h2>
                </div>
              </div>

              <div class="box-body bg-logo">
                <div class="pull-left p-a-sm">
                  Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r" />
                </div>
                <div>
                  <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="5">
                    <thead>
                      <tr>
                        <td>ID</td>
                        <td>Amount</td>
                        <td>Coin Name</td>
                        <td>Percent</td>
                        <td>Amount USD</td>
                        <td>DateTime</td>
                        <td>Status</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($investment as $i)
                      <tr>
                        <td>{{$i->investment_ID}}</td>
                        <td>{{$i->investment_Amount + 0}}</td>
                        <td>{{$i->Currency_Name}}</td>
                        <td>{{0}}</td>
                        <td>{{$i->investment_Amount * $i->investment_Rate}}</td>
                        <td>{{date('Y-m-d H:i:s', $i->investment_Time)}}</td>
                        <td>{{$i->investment_Status == 1 ? 'Success' : 'Canceled'}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                      <tr>
                        <td colspan="5" class="text-center">
                          <ul class="pagination"></ul>
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
  <div class="modal fade" id="modalConfirmAdddress" role="dialog">
    <div class="modal-dialog modals-default">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h2 class="text-center">Confirm Address</h2>
          <p class="text-center">Do You Want Confirm Address: </p>
          <p class="text-center"><b class="address-meta text-center"></b></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn success" id="btn-Confirm-Address">Confirm</button>
          <button type="button" class="btn danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ############ PAGE END-->
</div>

@endsection
@section('script')
{{-- <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script> --}}
{{-- <script src="../js/custom.js?v={{time()}}"></script> --}}

<script>
  $(document).ready(function () {
      
      $('.deposit').click(function(){
          _coin = $(this).attr('data-id');
          getAddress(_coin);
      });
      
      
      function getAddress(_coin){
        $.getJSON( "{{ route('system.json.getAddress') }}?coin="+_coin, function( data ) {
            Swal.fire({
                titleText: "Deposit "+data['name'],
                html: '<div class="pay--attention">PLEASE COPY WALLET ADDRESS OR SCAN QR CODE AND THEN WAITING THE SYSTEM PROCESS YOUR REQUEST...</div>'+
                        '<div class="send--to">Send to address:</div>'+
                        
                        '<div class="the--address"><b style="font-weight: 900;">'+data['address']+'</b></div>'+
                        '<br>'+
                        '<img src="'+data['Qr']+'" style="width: 90%;"></img>'
            })
            
          $('#inputAddress').val(data['address']);
          $('#ImageQr').html('<img src="'+data['Qr']+'" style="margin: 0 auto;"/>');
      });
      }
      
    });
  </script>
  <script>
	  rateCoin = {'ETH': {{ $rate['ETH'] }}, 'RBD': {{ $rate['RBD'] }}, 'USDT': 1};
  </script>
@endsection

