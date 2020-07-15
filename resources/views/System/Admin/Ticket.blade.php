@extends('System.Layouts.Master')
@section('title')
Admin Ticket
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
									<h2><i class="fa fa-table"></i> Ticket</h2>
								</div>
							</div>
							<div class="box-body bg-logo">
								<div class="pull-left p-a-sm">
									Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r"/>
								</div>
								<div>
									<table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="5">
										<thead>
											<tr>
												<th data-toggle="true">
													ID
												</th>
												<th>
													SUBJECTS
												</th>
												<th data-hide="phone,tablet">
													CUSTOMER
												</th>
												<th data-hide="phone">
													STATUS
												</th>
												<th data-hide="phone">
													DATE
												</th>
												<th data-hide="phone">
													
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label warning" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label danger" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label warning" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label success" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label warning" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label success" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>Shona</td>
												<td>Woldt</td>
												<td>>Airline Transport Pilot</td>
												<td>3 Oct 1981</td>
												<td data-value="3"><span class="label warning" title="Suspended">Suspended</span></td>
												<td>
													<div class="btn-groups">
														<a href="{{ route('system.getDetailTicket') }}" class="btn btn-outline success"><i class="fa fa-server" aria-hidden="true"></i> Detail</a>
														<a class="btn btn-outline danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
													</div>
												</td>
											</tr>
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