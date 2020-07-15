@extends('System.Layouts.Master')
@section('title')
    Admin Investment
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
                        <form method="get" action="{{route('system.admin.getInvestment')}}">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <h2><i class="fa fa-usd" aria-hidden="true"></i> Investment</h2>
                                            </div>
                                            <div class="box-divider m-a-0"></div>
                                            <div class="box-body bg-logo">
                                                <div class="row m-b p-a">
                                                    <div class="col-md-6">
                                                        <label for="single-prepend-text">ID</label>
                                                        <div class="input-group m-b">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-user"></i></span>
                                                            <input type="text" name="user_id" class="form-control"
                                                                   placeholder="Enter ID">
                                                        </div>
                                                        <label for="single-prepend-text">Email</label>
                                                        <div class="input-group m-b">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" name="email" class="form-control"
                                                                   placeholder="Enter Email">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="single-prepend-text">Status</label>
                                                            <div class="input-group select2-bootstrap-prepend">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                              <span class="fa fa-caret-down"></span>
                              </button>
                            </span>
                                                                <select id="single-prepend-text" name="status"
                                                                        class="form-control select2"
                                                                        data-ui-jp="select2"
                                                                        data-ui-options="{theme: 'bootstrap'}">
                                                                    <option value="1">Active</option>
                                                                    <option value="-1">Cancel</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="single-prepend-text">From</label>
                                                        <div class="form-group">
                                                            <div class='input-group date' data-ui-jp="datetimepicker"
                                                                 data-ui-options="{
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
                                                                <input type='text' name="datefrom"
                                                                       class="form-control"/>
                                                                <span class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </span>
                                                            </div>
                                                        </div>
                                                        <label for="single-prepend-text">To</label>
                                                        <div class="form-group">
                                                            <div class='input-group date' data-ui-jp="datetimepicker"
                                                                 data-ui-options="{
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
                                                                <input type='text' name="dateto" class="form-control"/>
                                                                <span class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </span>
                                                            </div>
                                                        </div>
                                                        <label for="single-prepend-text" style="opacity: 0">To</label>
                                                        <div class="text-left">
                                                            <button class="btn btn-outline info"><i class="fa fa-search"
                                                                                                    aria-hidden="true"></i>
                                                                Search
                                                            </button>
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
                                        <h2><i class="fa fa-table"></i> List Investment</h2>
                                    </div>
                                    <div class="pull-right">
                                        <h2>Total: $123456</h2>
                                    </div>
                                </div>
                                <div class="box-body bg-logo">
                                    <div class="p-a-sm pull-left">
                                        Search: <input id="filter" type="text"
                                                       class="form-control input-sm w-auto inline m-r"/>
                                    </div>
                                    <div class="pull-right p-r-md">
                                        <div class="btn-groups">
                                            <button class="btn btn-outline b-info text-info"><i
                                                    class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
                                            </button>
                                            <button class="btn btn-outline b-success text-success"><i
                                                    class="fa fa-print" aria-hidden="true"></i> Print
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table m-b-none" data-page-size="5">
                                            <thead>
                                            <tr>
                                                <th data-toggle="true">
                                                    ID
                                                </th>
                                                <th>
                                                    USDER ID
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    lEVEL
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    AMOUNT
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    AMOUNT USD
                                                </th>
                                                <th data-hide="phone,tablet">
                                                    RATE
                                                </th>
                                                <th data-hide="phone">
                                                    CURRENCY
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
                                            @foreach($investmentList as $item)
                                                <tr>
                                                    <td>{{$item->investment_ID}}</td>
                                                    @if($item->User_Level == 0)
                                                        <td>{{$item->investment_User}}</td>
                                                        <th>User</th>
                                                    @elseif($item->User_Level == 1)
                                                        <td class="bg-success">{{$item->investment_User}}</td>
                                                        <th>Admin</th>
                                                    @elseif($item->User_Level == 2)
                                                        <td class="bg-info">{{$item->investment_User}}</td>
                                                        <th>Finance</th>
                                                    @else
                                                        <td class="bg-warning">{{$item->investment_User}}</td>
                                                        <th>Test</th>
                                                    @endif
                                                    <td>{{number_format($item->investment_Amount + 0)}}</td>
                                                    <td>{{number_format($item->investment_Amount*$item->investment_Rate,2)}}</td>
                                                    <td>{{number_format($item->investment_Rate, 3)}}</td>
                                                    <td>{{$item->Currency_Name}}</td>
                                                    <td>{{date('Y-m-d H:i:s', $item->investment_Time)}}</td>
                                                    @if($item->investment_Status == 1)
                                                        <td>Active</td>
                                                    @else
                                                        <td>Cancel</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot class="hide-if-no-paging">
                                            <tr>
                                                <td colspan="12" class="text-center">
                                                    <ul class="pagination">{{ $investmentList->appends(request()->input())->links()}}</ul>
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
