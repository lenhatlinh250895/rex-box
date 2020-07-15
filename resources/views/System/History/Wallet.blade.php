@extends('System.Layouts.Master')
@section('title')
History Wallet
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
          <div class="col-md-12">
            <div class="box">
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-history"></i> History Wallet</h2>
                </div>
              </div>
              <div class="box-body bg-logo">
                <div class="pull-left p-a-sm">
                  Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
                </div>
                <div class="pull-right p-r-md">
                  <div class="btn-groups">
                    <button class="btn btn-outline b-info text-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                    <button class="btn btn-outline b-success text-success"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                  </div>
                </div>
                <div>
                  <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="20">
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
                          COMMENT
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($walletHistory as $item)
                        <tr>
                            <td>{{$item['Money_ID']}}</td>
                            <td style="word-break: break-all;">{{number_format($item['Money_USDT'], 2)}}</td>
                            <td>{{$item['MoneyAction_Name']}}</td>
                            <td>{{number_format($item['Money_USDTFee'], 2)}}</td>
                            <td>{{number_format($item['Money_Rate'], 4)}}</td>
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
  <!-- ############ PAGE END-->
</div>
@endsection
@section('script')
@endsection
