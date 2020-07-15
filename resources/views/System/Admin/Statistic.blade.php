@extends('System.Layouts.Master')
@section('title')
Admin Statistical
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
          <form method="get" action="{{route('system.admin.getStatistical')}}">
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
                          <div class="form-group">
                            <label for="single-prepend-text">Level</label>
                            <div class="input-group select2-bootstrap-prepend">
                              <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                                  <span class="fa fa-caret-down"></span>
                                </button>
                              </span>
                              <select id="single-prepend-text" name="action" class="form-control select2"
                                data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                                <option value="" selected>---select---</option>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
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
                              <input type='text' name="from" class="form-control" />
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
                              <input type='text' name="to" class="form-control" />
                              <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                              </span>
                            </div>
                          </div>
                          <div class="pull-left">
                            <div class="btn-groups">
			                  <button class="btn btn-primary info" type="submit"><i class="fa fa-search" aria-hidden="true"></i>
			                    Search</button>
			                  <button class="btn btn-default success" type="button" id="exportTest"><i class="fa fa-print" aria-hidden="true">Export</i>
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
                  <h2><i class="fa fa-history"></i> Statistical</h2>
                </div>
              </div>
              <div class="box-body bg-logo">
                <div class="p-a-sm">
                  Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r" />
                </div>
                <div class="table-responsive">
                  <table class="table m-b-none" data-page-size="5">
	                  <thead>
						<tr style="color: #fff; text-align: center">
							<th rowspan="2" class="border-right" style="text-align: center;vertical-align: middle;">User ID</th>
							<th rowspan="2" class="border-right" style="text-align: center;vertical-align: middle;">Email</th>
							<th rowspan="2" class="border-right" style="background-color:none;text-align: center;vertical-align: middle;">User Level</th>
							<th colspan="2" class="border-right" style="text-align: center;vertical-align: middle;">Balance</th>
							<th colspan="3" style="text-align:center" class="border-right">Deposit</th>
							<th colspan="3" style="text-align:center" class="border-right">Withdraw</th>
							<th colspan="2" style="text-align:center" class="border-right">Transfer</th>
							<th colspan="2" style="text-align:center" class="border-right">Give Transfer</th>
							<th colspan="2" style="text-align:center" class="border-right">Buy ITO</th>
							<th colspan="2" style="text-align:center" class="border-right">Sell ITO</th>
							<th colspan="1" style="text-align:center" class="border-right">ITO Commission</th>
							
{{--						<th colspan="3" class="border-right" style="text-align: center;vertical-align: middle;">Investment</th>
							<th colspan="3" class="border-right" style="text-align: center;vertical-align: middle;">Cancel Investment</th>
							<th colspan="2" class="border-right" style="text-align: center;vertical-align: middle;">Interest</th>
							<th colspan="2" style="text-align:center" class="border-right">Direct Com</th>
							<th colspan="2" style="text-align:center" class="border-right">Indirect Com</th>
							<th colspan="2" style="text-align:center" class="border-right">Affiliate Com</th>--}}
						</tr>

                        <tr>
<!-- 							balance -->
							<th class="text-right">RBD</th>
							<th class="text-right border-right">USD</th>
<!-- 							deposit -->
							<th class="text-right">BTC</th>
							<th class="text-right">ETH</th>
							<th class="text-right border-right">RBD</th>
<!-- 							withdraw -->
							<th class="text-right">BTC</th>
							<th class="text-right">ETH</th>
							<th class="text-right border-right">RBD</th>
<!-- 							transfer -->
							<th class="text-right">RBD</th>
							<th class="text-right border-right">USD</th>
							
							<th class="text-right">RBD</th>
							<th class="text-right border-right">USD</th>
<!-- 												buy ITO -->
							<th class="text-right">RBD</th>
							<th class="text-right border-right">USD</th>
<!-- 												sell ITO -->
							<th class="text-right">RBD</th>
							<th class="text-right border-right">USD</th>
							
							<th class="text-right">USD</th>
{{--	
<!-- 							investment -->
							<th class="text-right">RBD</th>
							<th class="text-right">BTC</th>
							<th class="text-right border-right">ETH</th>

							<th class="text-right">RBD</th>
							<th class="text-right">BTC</th>
							<th class="text-right border-right">ETH</th>

							
							<th class="text-right">RBD</th>
							<th class="text-right border-right">ETH</th>
							
							<th class="text-right">RBD</th>
							<th class="text-right border-right">ETH</th>
							
							<th class="text-right">RBD</th>
							<th class="text-right border-right">ETH</th>
							
							<th class="text-right">RBD</th>
							<th class="text-right border-right">ETH</th>--}}
						</tr>
                    </thead>
                    <tbody>
							<tr>
								<td colspan="3" rowspan="1" class="text-center"> Total</td>
								
								<td class="text-right">{{ $Total->BalanceRBD }}</td>
								<td class="text-right">{{ $Total->BalanceUSD }}</td>
								
								<td class="text-right">{{ $Total->DepositBTC }}</td>
								<td class="text-right">{{ $Total->DepositETH }}</td>
								<td class="text-right">{{ $Total->DepositRBD }}</td>
								
								<td class="text-right">{{ $Total->WithDrawBTC }}</td>
								<td class="text-right">{{ $Total->WithDrawETH }}</td>
								<td class="text-right">{{ $Total->WithDrawRBD }}</td>
								
								<td class="text-right">{{ $Total->TransferRBD }}</td>
								<td class="text-right">{{ $Total->TransferUSD }}</td>
								
								<td class="text-right">{{ $Total->GiveRBD }}</td>
								<td class="text-right">{{ $Total->TransferUSD }}</td>
								
								<td class="text-right">{{ $Total->BuyRBD }}</td>
								<td class="text-right">{{ $Total->BuyUSD }}</td>
								
								<td class="text-right">{{ $Total->SellRBD }}</td>
								<td class="text-right">{{ $Total->SellToUSD }}</td>
								
								<td class="text-right">{{ $Total->ITOComUSD }}</td>

								{{--<td class="text-right">{{ $Total->InvestmentRBD }}</td>
								<td class="text-right">{{ $Total->InvestmentBTC }}</td>
								<td class="text-right">{{ $Total->InvestmentETH }}</td>

								<td class="text-right">{{ $Total->CancelRBD }}</td>
								<td class="text-right">{{ $Total->CancelBTC }}</td>
								<td class="text-right">{{ $Total->CancelETH }}</td>
								
								<td class="text-right">{{ $Total->Profit }}</td>
								<td class="text-right">{{ $Total->ProfitETH }}</td>
								
								<td class="text-right">{{ $Total->Direct }}</td>
								<td class="text-right">{{ $Total->DirectETH }}</td>
								<td class="text-right">{{ $Total->Indirect }}</td>
								<td class="text-right">{{ $Total->IndirectETH }}</td>
								<td class="text-right">{{ $Total->Affiliate }}</td>
								<td class="text-right">{{ $Total->Affiliate }}</td>--}}
								
							</tr>
                        @foreach($Statistic as $statistic)
                        
							@php
								$abc = App\Models\User::where('User_ID',$statistic->Money_User)->first()->User_Level;

								$bg_color = "";
								if($abc == 1 || $abc == 2 || $abc == 3 || $abc == 4){
									$bg_color = 'background-color:#FF5722!important';
								}
							@endphp
							<tr>
								<td style="{{ $bg_color }}"><a class="text-white" href="{{route('system.admin.getMember')}}?UserID={{$statistic->Money_User}}">{{ $statistic->Money_User }}</a></td>
								<td style="{{ $bg_color }}"><a class="text-white" href="{{route('system.admin.getMember')}}?UserID={{$statistic->Money_User}}">{{ $statistic->User_Email }}</a></td>
								<td class="text-right">{{ $statistic->User_Block == 0 ? $level[$abc] : 'Blocked' }}</td>
								<td class="text-right">{{ $statistic->BalanceRBD }}</td>
								<td class="text-right">{{ $statistic->BalanceUSD }}</td>
								
								<td class="text-right">{{ $statistic->DepositBTC }}</td>
								<td class="text-right">{{ $statistic->DepositETH }}</td>
								<td class="text-right">{{ $statistic->DepositRBD }}</td>
								
								<td class="text-right">{{ $statistic->WithDrawBTC }}</td>
								<td class="text-right">{{ $statistic->WithDrawETH }}</td>
								<td class="text-right">{{ $statistic->WithDrawRBD }}</td>
								
								<td class="text-right">{{ $statistic->TransferRBD }}</td>
								<td class="text-right">{{ $statistic->TransferUSD }}</td>
								
								<td class="text-right">{{ $statistic->GiveRBD }}</td>
								<td class="text-right">{{ $statistic->TransferUSD }}</td>
								
								<td class="text-right">{{ $statistic->BuyRBD }}</td>
								<td class="text-right">{{ $statistic->BuyUSD }}</td>
								
								<td class="text-right">{{ $statistic->SellRBD }}</td>
								<td class="text-right">{{ $statistic->SellToUSD }}</td>
								
								<td class="text-right">{{ $statistic->ITOComUSD }}</td>

								{{--<td class="text-right">{{ $Total->InvestmentRBD }}</td>
								<td class="text-right">{{ $Total->InvestmentBTC }}</td>
								<td class="text-right">{{ $Total->InvestmentETH }}</td>

								<td class="text-right">{{ $Total->CancelRBD }}</td>
								<td class="text-right">{{ $Total->CancelBTC }}</td>
								<td class="text-right">{{ $Total->CancelETH }}</td>
								
								<td class="text-right">{{ $Total->Profit }}</td>
								<td class="text-right">{{ $Total->ProfitETH }}</td>
								
								<td class="text-right">{{ $Total->Direct }}</td>
								<td class="text-right">{{ $Total->DirectETH }}</td>
								<td class="text-right">{{ $Total->Indirect }}</td>
								<td class="text-right">{{ $Total->IndirectETH }}</td>
								<td class="text-right">{{ $Total->Affiliate }}</td>
								<td class="text-right">{{ $Total->Affiliate }}</td>--}}												
							</tr>
						@endforeach
                    </tbody>
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
	<script src="https://redboxtrade.com/jquery-table2excel/dist/jquery.table2excel.min.js"></script>
	<script>
		$(function() {
			$('#exportTest').click(function(){
				$("#content").table2excel({
					exclude: ".noExl",
					name: "Statistical",
					filename: "Statistical" + new Date().toISOString().replace(/[\-\:\.]/g, "")+".xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
				
			});
			$('#content').DataTable({
				"order": [[ 0, "desc" ]]
			});
		});
	</script>
@endsection