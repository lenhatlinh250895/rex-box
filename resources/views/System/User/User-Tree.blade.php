@extends('System.Layouts.Master')
@section('title')
Member Tree
@endsection
@section('css')
<link rel="stylesheet" href="orgchart/jquery.orgchart.css">
<link rel="stylesheet" href="orgchart/style.css?v={{ time()}}">
<style>
    .node-empty {
        border: 0 !important;
        padding: 0 !important;
    }

    .orgchart {
        background-image: none;
    }

    .orgchart .node .title {
        width: auto;
    }

    table {
        margin: auto;
    }
</style>
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
                                    <button class="btn btn-fw blue copytooltip" id="tooltiptext"
                                        onclick="copyToClipboard()"><i class="fa fa-file-o"></i> Copy</button>
                                    <button
                                        class="btn btn-rounded btn-noborder ml-10 btn-{{$side_current == 0 ? 'primary' : 'secondary'}}"
                                        data-value="0" id="btn-left-side">Left</button>
                                    <button
                                        class="btn btn-rounded btn-noborder ml-10 btn-{{$side_current == 0 ? 'secondary' : 'primary'}}"
                                        data-value="1" id="btn-right-side">Right</button>
                                </div>
                                {{--                </form>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h2><i class="fa fa-search"></i> Search</h2>
                            </div>
                            <div class="box-divider m-a-0"></div>
                            <div class="box-body bg-logo">
                                <div id="edit-panel" class="view-state">
                                    <div class="form-group">
                                        <input type="text" id="selected-node" placeholder="Please enter User ID"
                                            class="form-control">
                                    </div>
                                    <div class="">
                                        <button type="button" id="btn-report-path"
                                            class="btn btn-rounded btn-noborder btn-info min-width-125 mr-2"><i
                                                class="fa fa-search" aria-hidden="true"></i>
                                            Search</button>
                                        <button type="button" id="btn-reset"
                                            class="btn btn-rounded btn-noborder btn-danger min-width-125"><i
                                                class="fa fa-times" aria-hidden="true"></i>
                                            Cancel</button>
                                    </div>

                                </div>




                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header pd-b-2">
                                <div class="pull-left">
                                    <h2><i class="fa fa-user"></i> Member Tree</h2>
                                </div>
                            </div>

                            <div class="row">
                                <div id="chart-container"></div>
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
<!-- The Modal -->
<div class="modal" id="showInfo">
    <div class="modal-dialog">
        <div class="modal-content" id="info">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Information</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">UserID</label>
                        <input type="text" id="userid" value="" class="form-control" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="">Email</label>
                        <input type="text" id="email" value="" class="form-control" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="">Left Total</label>
                        <input type="text" name="left" id="left" value="" class="form-control" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="">Right Total</label>
                        <input type="text" name="right" id="right" value="" class="form-control" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="">Total Members</label>
                        <div class="children-flex"
                            style="display: flex; justify-content: space-around; justify-items: center;">
                            <span class="children-left">
                            </span>
                            <span class="children-right">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-noborder btn-danger min-width-125 mb-10"
                    data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<div class="modal" id="addChild">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Please add your details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="js-validation-signup" action="{{ route('system.user.postMemberAdd')}}" method="POST"
                    id="sign-up-form">
                    @csrf
                    <input type="hidden" id="node_side" name="node_side">
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <label for="signup-username">Username</label>
                            <input type="text" class="form-control" id="signup-username" name="UserName" value=""
                                placeholder="User Name" required>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <label for="signup-email">Email</label>
                            <input type="email" class="form-control" id="signup-email" placeholder="Email" value=""
                                name="Email" required>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <label for="signup-password">Password</label>
                            <input type="password" class="form-control" id="signup-password" placeholder="********"
                                name="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="signup-password-confirm">Password Confirmation</label>
                            <input type="password" class="form-control" id="signup-password-confirm"
                                placeholder="********" name="Re-Password">
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Sponsor</label>
                            <input type="text" class="form-control" name="parent" id="parent" value=""
                                autocomplete="off" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Presenter</label>
                            <input type="text" name="brother" id="brother" class="form-control" value=""
                                autocomplete="off" readonly />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Link Ref</label>
                            <input type="text" id="link_ref" class="form-control" value="" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-3 text-center">
                        </div>
                        <div class="col-sm-6 text-center">

                            <button type="submit" class="btn btn-rounded btn-noborder btn-info min-width-125 mb-10"
                                style="margin-top: 12px;">
                                <i class="fa fa-plus mr-10"></i> Add User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-noborder btn-danger min-width-125 mb-10"
                    data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
<script src="orgchart/jquery.orgchart.js"></script>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("linkRef");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        var tooltip = document.getElementById("tooltiptext");
    }
</script>
<script type="text/javascript">
    $(function() {
        var datascource = {!! $list !!};
        var getId = function() {
          return (new Date().getTime()) * 1000 + Math.floor(Math.random() * 1001);
        };
    
        var oc = $('#chart-container').orgchart({
            'data' : datascource,
            'nodeContent': 'title',
            'visibleLevel': 2,
            'createNode': function($node, data) {
                $node.on('click', '.edge', function (event) {
                if ($(event.target).is('.fa-chevron-down')) {
                  showDescendents(this, 2);
                }
              });
            }
        });
        var showDescendents = function(node, visibleLevel) {
          if (visibleLevel === 1) {
            return false;
          }
          $(node).closest('tr').siblings(':last').children().find('.node:first').each(function(index, node) {
            var $temp = $(node).closest('tr').siblings().removeClass('hidden');
            var $children = $temp.last().children().find('.node:first');
            if ($children.length) {
            $children[0].style.offsetWidth = $children[0].offsetWidth;
          }
          $children.removeClass('slide-up');
          showDescendents(node, visibleLevel--);
          });
        };
    
        oc.$chartContainer.on('click', '.node', function() {
            
            if($(this).hasClass('node-tree')){
                console.log($(this).attr('id'));
                $.ajax({
                    type: "GET",
                    url: "{{ route('system.getAjaxSaleUser') }}",
                    data: {
                        'User_ID': $(this).attr('id'),
                    },
                    success: function (data) {
                        if(data.status == 200){
                            console.log(data.infor);
                            console.log(data.sales);
    
                            $('#info #userid').val(data.infor.User_ID);
                            $('#info #email').val(data.infor.User_Email);
                            $('#left').val(data.sales.leftTrade ? ''+data.sales.leftTrade+' RBD' : ''+0+' RBD');
                            $('#right').val(data.sales.rightTrade ? ''+data.sales.rightTrade+' RBD' : ''+0+' RBD');
                            $('.children-left').html(data.count_children.children_left ? 'Left: '+data.count_children.children_left : 'Left: '+0);
                            $('.children-right').html(data.count_children.children_right ? 'Right: '+data.count_children.children_right : 'Right: '+0);
                        }
                        
                        console.log(data);
                    }
                });
                $('#showInfo').modal('show');
    
            }
            else{
                let sponsor = '{{ Session('user')->User_ID }}';

                if($(this).hasClass('left')){
                    $node_side = 0;
                }
                if($(this).hasClass('right')){
                    $node_side = 1;
                }
                $('#addChild').modal('show');
                
                $('#parent').val(sponsor);
                $('#brother').val($(this).attr('data-parent'));
                $('#node_side').val($node_side);
                $('#link_ref').val("{{route('getRegister')}}"+"?ref="+sponsor+"&presenter="+$(this).attr('data-parent')+"");
            }
            var $this = $(this);
          
        });
    
        $('#btn-report-path').on('click', function() {
            $('#chart-container').find('.hidden').removeClass('hidden').end().find('.slide-up, .slide-right, .slide-left, .focused').removeClass('slide-up slide-right slide-left focused');
            var val_search = isNaN($('#selected-node').val());
            var get_val = $('#selected-node').val().toUpperCase();
            setTimeout(function(){
    
                if(val_search == true){
                $('.'+get_val).addClass('focused');
                console.log('string');
                console.log($('.'+get_val));
                }else{
                    console.log(get_val);
                    $('#'+get_val).addClass('focused');
                    console.log('number');
    
                }
                
                var $selected = $('#chart-container').find('.node.focused');
                if ($selected.length) {
                    $selected.parents('.nodes').children(':has(.focused)').find('.node:first').each(function(index, superior) {
                    if (!$(superior).find('.horizontalEdge:first').closest('table').parent().siblings().is('.hidden')) {
                        $(superior).find('.horizontalEdge:first').trigger('click');
                    }
                    });
                } else {
                    alert('Data does not exist');
                }
            }, 1);
            
        });
        $('#btn-reset').on('click', function() {
          $('#chart-container').find('.hidden').removeClass('hidden')
            .end().find('.slide-up, .slide-right, .slide-left, .focused').removeClass('slide-up slide-right slide-left focused');
          $('#selected-node').val('');
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.node-empty .title').css({
            'opacity' : 0,
            'height' : 0,
            'padding' : 0,
        });
        $('.node-empty i, .node-empty .content').hide();
        $('.node-empty').append('<img src="orgchart/plus.png" alt="" style="width: 45px;">');

    });

           
</script>
<script>
    $('#btn-left-side').click(function () {
        if($(this).hasClass('btn-secondary')){
            $(this).removeClass('btn-secondary').addClass('btn-primary');
        }
        if($('#btn-right-side').hasClass('btn-primary')){
            $('#btn-right-side').removeClass('btn-primary').addClass('btn-secondary');
        }
        side_active = $(this).attr('data-value');
        $.ajax({
            url: '{{ route('changeSideActive')}}',
            type: 'GET',
            data: {'side_active': side_active},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data['status'] == 'success') {
                    toastr.success(data['message'], 'Success!', {timeOut: 3500})
                }
                else {
                    toastr.error(data['message'], 'Error!', {timeOut: 3500})
    
                }
            }
        });
    });
    
    $('#btn-right-side').click(function () {
        if($(this).hasClass('btn-secondary')){
            $(this).removeClass('btn-secondary').addClass('btn-primary');
        }
        if($('#btn-left-side').hasClass('btn-primary')){
            $('#btn-left-side').removeClass('btn-primary').addClass('btn-secondary');
        }
        side_active = $(this).attr('data-value');
        $.ajax({
            url: '{{ route('changeSideActive')}}',
            type: 'GET',
            data: {'side_active': side_active},
            dataType: 'json',
            success: function (data) {
                if (data['status'] == 'success') {
                    toastr.success(data['message'], 'Success!', {timeOut: 3500})
                }
                else {
                    toastr.error(data['message'], 'Error!', {timeOut: 3500})
    
                }
    
            }
        });
    });
</script>
@endsection