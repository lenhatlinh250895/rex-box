@extends('System.Layouts.Master')
@section('title')
Admin Withdraw
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
            <div class="row">
              <div class="col-sm-12">
                <div class="box">
                  <div class="box-header">
                    <h2><i class="fa fa-usd" aria-hidden="true"></i> Withdraw</h2>
                  </div>
                  <div class="box-divider m-a-0"></div>
                  <div class="box-body bg-logo">
                    <div class="row m-b p-a">
                      <div class="col-md-6">
                        <label for="single-prepend-text">ID</label>
                        <div class="input-group m-b">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" placeholder="Enter ID">
                        </div>
                        <label for="single-prepend-text">Email</label>
                        <div class="input-group m-b">
                          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="text" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                          <label for="single-prepend-text">Status</label>
                          <div class="input-group select2-bootstrap-prepend">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
                              <span class="fa fa-caret-down"></span>
                              </button>
                            </span>
                            <select id="single-prepend-text" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                              <option value="A">Pedding</option>
                              <option value="B">Confirmed</option>
                              <option value="B">Error</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="single-prepend-text">From</label>
                        <div class="form-group">
                          <div class='input-group date' data-ui-jp="datetimepicker" data-ui-options="{
                            format: 'DD/MM/YYYY',
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
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </span>
                          </div>
                        </div>
                        <label for="single-prepend-text">To</label>
                        <div class="form-group">
                          <div class='input-group date' data-ui-jp="datetimepicker" data-ui-options="{
                            format: 'DD/MM/YYYY',
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
                            <input type='text' class="form-control" />
                            <span class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </span>
                          </div>
                        </div>
                        <div class="pull-left">
                          <label for="single-prepend-text" style="opacity: 0">To</label>
                          <div class="btn-groups">
                            <button class="btn btn-outline info"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="box">
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-table"></i> Withdraw Confirm</h2>
                </div>
                <div class="pull-right">
                  <h2>Total: $123456</h2>
                </div>
              </div>
              <div class="box-body bg-logo">
                <div class="p-a-sm">
                  Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
                </div>
                <div>
                  <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="5">
                    <thead>
                      <tr>
                        <th data-toggle="true">
                          WITHDRAWAL ID
                        </th>
                        <th>
                          WITHDRAWAL USER
                        </th>
                        <th data-hide="phone,tablet">
                          USER LEVEL
                        </th>
                        <th data-hide="phone,tablet">
                          WITHDRAWAL AMOUNT
                        </th>
                        <th data-hide="phone">
                          MONEY RATE
                        </th>
                        <th data-hide="phone">
                          WITHDRAW TIME
                        </th>
                        <th data-hide="phone">
                          STATUS
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Isidra</td>
                        <td><a href="#">Boudreaux</a></td>
                        <td>Traffic Court Referee</td>
                        <td data-value="78025368997">22 Jun 1972</td>
                        <td data-value="1"><span class="label success" title="Active">Active</span></td>
                        <td>Leonardo</td>
                        <td>
                          <div class="btn-groups">
                            <button class="btn btn-outline success"><i class="fa fa-check" aria-hidden="true"></i> Confirm</button>
                            <button class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Shona</td>
                        <td>Woldt</td>
                        <td><a href="#">Airline Transport Pilot</a></td>
                        <td data-value="370961043292">3 Oct 1981</td>
                        <td data-value="2"><span class="label" title="Disabled">Disabled</span></td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                      </tr>
                      <tr>
                        <td>Granville</td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                        <td data-value="-22133780420">19 Apr 1969</td>
                        <td data-value="3"><span class="label warning" title="Suspended">Suspended</span></td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                      </tr>
                      <tr>
                        <td>Easer</td>
                        <td>Dragoo</td>
                        <td>Drywall Stripper</td>
                        <td data-value="250833505574">13 Dec 1977</td>
                        <td data-value="1"><span class="label success" title="Active">Active</span></td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                      </tr>
                      <tr>
                        <td>Shona</td>
                        <td>Woldt</td>
                        <td><a href="#">Airline Transport Pilot</a></td>
                        <td data-value="370961043292">3 Oct 1981</td>
                        <td data-value="2"><span class="label danger" title="Disabled">cancel</span></td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                      </tr>
                      <tr>
                        <td>Granville</td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                        <td data-value="-22133780420">19 Apr 1969</td>
                        <td data-value="3"><span class="label warning" title="Suspended">Suspended</span></td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                      </tr>
                      <tr>
                        <td>Easer</td>
                        <td>Dragoo</td>
                        <td>Drywall Stripper</td>
                        <td data-value="250833505574">13 Dec 1977</td>
                        <td data-value="1"><span class="label success" title="Active">Active</span></td>
                        <td>Leonardo</td>
                        <td>Business Services Sales Representative</td>
                      </tr>
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                    <tr>
                      <td colspan="12" class="text-center"><ul class="pagination"></ul></td>
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