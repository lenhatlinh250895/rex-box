@extends('System.Layouts.Master')
@section('title')
History Investment
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
                  <h2><i class="fa fa-history"></i> History Investment</h2>
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
                  <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="5">
                    <thead>
                      <tr>
                        <th data-toggle="true">
                          ID
                        </th>
                        <th>
                          INVESTMENT AMOUNT
                        </th>
                        <th data-hide="phone,tablet">
                          EXCHANGE RATE
                        </th>
                        <th data-hide="phone">
                          TIME
                        </th>
                        <th data-hide="phone">
                          STATUS
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($investmentHistory as $investmentItem)
                        <tr>
                            <td>{{$investmentItem->investment_ID}}</td>
                            <td style="word-break: break-all;">{{number_format($investmentItem->investment_Amount + 0)}}</td>
                            <td>{{number_format($investmentItem->investment_Rate, 3)}}</td>
                            <td>{{date('Y-m-d H:i:s', $investmentItem->investment_Time)}}</td>
                            @if($investmentItem->investment_Status = 1)
                                <td>Active</td>
                            @else
                                <td>Cancel</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                    <tr>
                      <td colspan="5" class="text-center"><ul class="pagination"></ul></td>
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
