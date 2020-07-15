@extends('System.Layouts.Master')
@section('title')
List Ticket
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
          <div class="col-md-6">
            <div class="box">
              <div class="box-header">
                <h2><i class="fa fa-link"></i> Ticket</h2>
              </div>
              <div class="box-divider m-a-0"></div>
              <div class="box-body bg-logo">

                <form action="{{route('postTicket')}}" method="post" class="parsley-examples">

                  @csrf
                  <div class="form-group">
                    <label class="control-label mb-10"><i class="fa fa-hand-o-down" aria-hidden="true"></i>
                      Subject</label>
                    <select name="subject" class="form-control" required>
                      @foreach($subject as $s)
                      <option value="{{$s->ticket_subject_id}}">
                        {{$s->ticket_subject_name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="email">Content * :</label>
                    <textarea placeholder="Description your problems..." name="content" id="commenttextarea" cols="30"
                      rows="5" class="form-control" required></textarea>
                  </div>
                  <div class="form-group mb-0">
                    <button type="submit" class="ladda-button btn btn-success waves-effect waves-light"
                      data-style="slide-down">
                      <span class="btn-label"><i class="fa fa-paper-plane"></i> </span>Send
                    </button>
                  </div>

                </form>

              </div>
            </div>


          </div>
          <div class="col-md-12">
            <div class="box">
              <div class="box-header pd-b-2">
                <div class="pull-left">
                  <h2><i class="fa fa-history"></i> List Ticket</h2>
                </div>
              </div>
              <div class="box-body bg-logo">
                <div class="table-responsive">
                  <div class="pull-left p-a-sm">
                    Search: <input id="filter" type="text" class="form-control input-sm w-auto inline m-r" />
                  </div>
                  <div>
                    <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter"
                      data-page-size="1000000000">
                      <thead>
                        <tr>
                          <th data-toggle="true">
                            ID
                          </th>
                          <th>
                            SUBJECTS
                          </th>
                          <th data-hide="phone">
                            STATUS
                          </th>
                          <th data-hide="phone">
                            DATE
                          </th>
                          <th data-hide="phone">
                            ACTION
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($ticket as $t)

                        @php
                        $findlastRep =
                        DB::table('ticket')->where('ticket_ReplyID',$t->ticket_ID)->orderBy('ticket_ID',
                        'DESC')->first();
                        if(!$findlastRep){
                        $status = 'Waiting';
                        $class = 'warning';
                        }else{
                        $getInfo = App\Model\User::whereIn('User_Level',
                        [1,2,3])->where('User_ID',
                        $findlastRep->ticket_User)->first();
                        if($getInfo){
                        $status = 'Replied';
                        $class = 'success';
                        }else{
                        $status = 'Waiting';
                        $class = 'warning';
                        }
                        }
                        @endphp
                        <tr>
                          <td>{{$t->ticket_ID}}</td>

                          <td>{{$t->ticket_subject_name}}</td>
                          <td>
                            <button class="btn btn-rounded btn-{{$class}}">{{$status}}</button>
                          </td>
                          <td>{{$t->ticket_Time}}</td>

                          <td><a href="{{route('getTicketDetail',$t->ticket_ID)}}"
                              class="btn btn-primary btn-rounded">Details</a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot class="hide-if-no-paging">
                        <tr>
                          <td colspan="6" class="text-center">
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
  </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
  $(document).ready(function(){
		$('.counter-value').each(function(){
			$(this).prop('Counter',0).animate({
				Counter: $(this).text()
			},{
				duration: 3500,
				easing: 'swing',
				step: function (now){
					$(this).text(Math.ceil(now));
				}
			});
		});
	});
</script>

@endsection
@section('script')
@endsection