@extends('layouts.app')
@section('title', 'login')
@section('sidebar')
    @parent
@endsection
@section('content')
    <!-- login -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>LOGIN</h3>
            </div>
            <div class="login">
                <div class="row">
                    <form class="col s12" onsubmit="return false">
                        <div class="input-field">
                            <input type="text" name="name" class="validate" placeholder="USERNAME" required>
                        </div>
                        <div class="input-field">
                            <input type="password" name="pass" class="validate" placeholder="PASSWORD" required>
                        </div>
                        <a href=""><h6>Forgot Password ?</h6></a>
                        <button class="btn button-default">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end login -->
@endsection
<script src="/js/jquery-1.12.4.min.js"></script>
<script>
    $(function () {
        $('.btn').click(function(){
            var name=$("input[name='name']").val();
            var pass=$("input[name='pass']").val();
            $.ajax({
                url:'/user/loginadd',
                data:{'name':name,'pass':pass},
                type:'post',
                dataType:'json',
                success:function (data) {
                    if(data.code==0){
                        alert(data.msg);
                        location.href="/home/index";
                    }else if(data.code==2){
                        alert(data.msg);
                        location.href="/user/reg";
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });
        return false;
    });
</script>