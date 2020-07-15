@extends('System.Layouts.Master')
@section('title')
Ticket Detail
@endsection
@section('css')
@endsection
@section('content')
<div class="app-body">
  <!-- ############ PAGE START-->
  <div class="row-col">
    <div class="col-lg b-r">
      <div class="padding padding-big">
        <div class="col-xs-12" id="detail">
          <div class="box">
            <div class="box-header pd-b-2">
              <div class="pull-left">
                <h2><i class="fa fa-server"></i> Ticket ID: <span>{{$ticket[0]->ticket_ID}}</span></h2>
              </div>
              <div class="pull-right">
                <h2>Subject: {{$ticket[0]->ticket_subject_name}}</h2>
              </div>
            </div>
            <div class="row-body bg-logo">
              <div class="row">
                <!-- content -->
                <div class="p-a-md">
                  @foreach($ticket as $t)
                  <div class="m-b">
                    <a href="javascript:void(0);" class="pull-left w-80 m-r-sm">
                      <span> {{$t->ticket_User}}</span>
                    </a>
                    <div class="clear">
                      <div>
                        <div class="p-a p-y-sm success inline rounded">
                          {{$t->User_Level == 1 ? 'Admin REDBOX' : $t->User_Email}}
                        </div>
                      </div>

                      <div class="m-t-xs">
                        <div class="p-a p-y-sm" style="background: #ece0e0; color: black;">
                          {!! $t->ticket_Content !!}
                        </div>
                      </div>
                      <div class="text-muted text-xs m-t-xs"><i class="fa fa-ok text-success"></i> {{ $t->ticket_Time }}</div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <!-- / -->
              </div>
              <div class="p-a b-t dark-white1 bd-bt">
                <form action="{{route('postTicket')}}" method="post" class="ticket-comment-form">
                  @csrf
                  <input type="hidden" name="subject" value="{{$ticket[0]->ticket_Subject}}">
                  <input type="hidden" name="replyID" value="{{$ticket[0]->ticket_ID}}">
                  <div class="input-group">
                    <input name="content" type="text" class="form-control" placeholder="Enter Content">
                    <span class="input-group-btn">
                      <button class="btn white b-a no-shadow" type="submit">
                        <i class="fa fa-send text-success"></i>
                      </button>
                    </span>
                  </div>
                </form>
              </div>
            </div>

            <!-- / -->

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