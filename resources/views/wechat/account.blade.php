@extends('layouts.app')

@section('title', '绑定已有账号')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="login">
        <div class="row">
            <form class="col s12">
                <div class="input-field">
                    <input type="text" class="validate" placeholder="请输入已有账号" required>
                </div>
                <a href="javascript:;" class="btn button-default" id="sub">提交</a>
            </form>
        </div>
    </div>
    <script>
        $(function(){
            $('#sub').click(function(){
                var account = $('.validate').val();
                var openid = "{{$openid}}";
                $.post(
                    '/accountdo',
                    {account:account,openid:openid},
                    function(res){
                        alert(res.msg);
                        if(res.num == 2){
                            location.href = "/";
                        }else if(res.num == 1){
                            location.href = "/user/reg";
                        }
                    },
                    'json'
                );
            });
        });
    </script>
@endsection