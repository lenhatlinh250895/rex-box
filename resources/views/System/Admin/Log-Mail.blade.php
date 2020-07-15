@extends('System.Layouts.Master')
@section('title')
Admin Log
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
                    <form method="GET" action="{{route('system.admin.getLogMail')}}">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="form-wrap">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-user" aria-hidden="true"></i> User
                                                            ID</label>
                                                        <input class="form-control" type="text" placeholder="User ID"
                                                            value="{{request()->input('UserID')}}" name="UserID">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i>
                                                            Email</label>
                                                        <input class="form-control" type="text" placeholder="Email"
                                                            value="{{request()->input('Email')}}" name="Email">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10" for="exampleInputpwd_1"><i
                                                                class="fa fa-users" aria-hidden="true"></i>
                                                            Content</label>
                                                        <input class="form-control" type="text" placeholder="Content"
                                                            value="{{request()->input('Content')}}" name="Content">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-actions mt-10">
                                                        <button type="submit"
                                                            class="btn-filler btn btn-lg1 btn-primary waves-effect"><i
                                                                class="fa fa-search" aria-hidden="true"></i>
                                                            Search
                                                        </button>

                                                        <a href="{{ route('system.admin.getLogMail') }}"
                                                            class="btn-filler btn btn-default mr-10">Cancel</a>
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

                            <div class="box-body bg-logo">
                                <div>
                                    {{$logMails->appends(request()->input())->links()}}
                                    <div style="clear:both"></div>
                                    <table id="dt-log-mail"
                                        class="dt-responsive table table-striped table-bordered table-responsive"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User ID</th>
                                                <th>Email</th>
                                                <th>Content</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($logMails as $item)
                                            <tr>
                                                <td>{{$item->Log_ID}}</td>
                                                <td>{{$item->Log_User}}</td>
                                                <td>{{$item->User_Email}}</td>
                                                <td>
                                                    <div style="overflow:auto;!important;height:110px">
                                                        {!!$item->Log_Content!!}
                                                    </div>
                                                </td>
                                                <td>{{$item->Log_Datetime}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$logMails->appends(request()->input())->links()}}

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