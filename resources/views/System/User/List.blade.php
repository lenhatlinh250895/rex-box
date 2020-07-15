@extends('System.Layouts.Master')
@section('title')
Member List
@endsection
@section('css')
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
  .copytooltip {
    position: relative;
    display: inline-block;
  }

  .copytooltip .tooltiptext {
    visibility: hidden;
    width: 100px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 150%;
    left: 50%;
    margin-left: -75px;
    opacity: 0.5;
    transition: opacity 0.3s;
  }

  .copytooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
  }

  .copytooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 0.5;
  }

	.box-body.bg-logo::-webkit-scrollbar-track
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		background-color: #fff0;
	}

	.box-body.bg-logo::-webkit-scrollbar
	{
		height: 2px;
		padding-bottom:5px;
		background-color: #fff0;
	}

	.box-body.bg-logo::-webkit-scrollbar-thumb
	{
		background-color: #fff0;
		border: 2px solid #fff0;
	}

  .dt-buttons {
    margin-top: 15px;
  }
</style>
@endsection
@section('content')
<div class="app-body">
  <!-- ############ PAGE START-->
  <div class="row-col">
    <div class="col-lg b-r">
      <div class="padding padding-big">
        <div class="row">
          <div class="col-md-6">
            <div class="box">
              <div class="box-header">
                <h2><i class="fa fa-link"></i> Link ref</h2>
              </div>
              <div class="box-divider m-a-0"></div>
              <div class="box-body bg-logo">
                {{--                <form role="form">--}}
                <div class="form-group">
                  <input type="text" class="form-control" id="linkRef" placeholder="Enter email"
                    value="{{route('getRegister')}}?ref={{Session('user')->User_ID}}" readonly>
                </div>
                <div class="btn-groups text-right">
                  <button class="btn btn-fw blue copytooltip" id="tooltiptext" onclick="copyToClipboard()"
                    onmouseout="hoverCopyTooltip()"><i class="fa fa-file-o"></i> Copy</button>
                </div>
                {{--                </form>--}}
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box">
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-user"></i> Member List (Total Sales: {{ number_format($total_buy_root, 4)}} RBD)</h2>
                </div>
                <div class="pull-right">
                  <h2><i class="fa fa-user"></i> Total Member: {{$membersList->count()}}</h2>
                </div>
              </div>
              <div class="box-body bg-logo" style="overflow-x: scroll;">
                <div class="pull-left p-a-sm">
                  Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r" />
                </div>
                {{--                <div class="pull-right p-r-md">--}}
                {{--                  <div class="btn-groups">--}}
                {{--                    <button class="btn btn-outline b-info text-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>--}}
                {{--                    <button class="btn btn-outline b-success text-success"><i class="fa fa-print" aria-hidden="true"></i> Print</button>--}}
                {{--                  </div>--}}
              
                
                <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="10">
                  <thead>
                    <tr>
                      <th aria-controls="datable_1" class="sorting_asc" colspan="1" rowspan="1" style=" width: auto; "
                        tabindex="0" >Level</th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">User ID
                      </th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">
                        Email</th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">Sponser
                      </th>
                      {{-- <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">
                        Amount Investment</th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">Sales
                      </th> --}}
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">
                        Buy (ITO)</th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">Sales (ITO)
                      </th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">Currency
                      </th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">Created Date
                      </th>
                      <th aria-controls="datable_1 " class="sorting " colspan="1 " rowspan="1 " style="width: auto; "
                        tabindex="0 ">Verification
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($membersList as $v)
                    <tr>

                      <td style="text-align: center">F{{ (int)$v->f }}</td>
                      <th class="text-center"><b>{{ $v->User_ID }}</b></th>
                      <td>{{ $v->User_Email }}</td>
                      <td class="text-center">{{ $v->User_Parent }}</td>
                      {{-- <td>
                        {{ number_format($v->aaa,2) }}


                      </td>
                      <td>
                        {{ number_format($v->total_invest_branch,2)}}
                      </td> --}}
                      <td>{{ number_format($v->buy, 2) }}</td>
                      <td>{{ number_format($v->total_buy_branch, 2) }}</td>
                      <th>RBD</th>
                      <td>{{ $v->User_RegisteredDatetime }}</td>
                      <td>
                        @if($v->Profile_Status == 1)
                        <span class="badge badge-success r-3">Verified</span>

                        @else
                        <span class="badge badge-danger r-3">Unverify</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                    

                  </tbody>
                  <tfoot class="hide-if-no-paging">
                    <tr>
                      <td colspan="9" class="text-center">
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
{{--    {{dd($membersList)}}--}}
<!-- ############ PAGE END-->
</div>
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function copyToClipboard() {
            var copyText = document.getElementById("linkRef");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            var tooltip = document.getElementById("tooltiptext");
        }

</script>
@endsection