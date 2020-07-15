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
          <div class="col-md-12">
            <div class="box">
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-history"></i> History Price</h2>
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
		                    DATE
		                  </th>
		                  <th data-hide="phone">
		                    PRICE
		                  </th>
		                  <th data-hide="phone">
		                    ACTION
		                  </th>
		                </tr>
                    </thead>
                    <tbody>
						@foreach($PriceToken as $p)
		                <tr>
							<td>{{$p->Changes_ID}}</td>
							<td>{{$p->Changes_Time}}</td>
							<td>{{$p->Changes_Price}}</td>
		                  <td>
							<form action="{{ route('system.admin.postPriceToken') }}" method="post">@csrf
								<div class="table-responsive">
									<input type="number" step="any" name="Price" placeholder="Amount"
										class="form-control" value="" required min="0">
								</div>
								<br>
								<input type="hidden" name="ID" value="{{$p->Changes_ID}}">
								<input type="hidden" name="priceOld" value="{{$p->Changes_Price}}">
								<button class="btn btn-success btn-rounded"><i class="fa fa-pencil-square-o"
										aria-hidden="true"></i> <span class="btn-text">Edit</span></button>
							</form>
		                  </td>
		                </tr>
		                @endforeach
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                      <tr>
                        <td colspan="12" class="text-center">
                          {{$PriceToken->appends(request()->input())->links()}}
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