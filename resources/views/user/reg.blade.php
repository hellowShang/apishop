@extends('layouts.app')
@section('title', 'reg')
@section('sidebar')
    @parent
@endsection
@section('content')
    <!-- register -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>REGISTER</h3>
            </div>
            <div class="register">
                <div class="row">
                    <form class="col s12" onsubmit="return false">
                        <div class="input-field">
                            <input type="text" name="name" class="validate" placeholder="NAME" required>
                        </div>
                        <div class="input-field">
                            <input type="email" name="email" placeholder="EMAIL" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="number" name="age" placeholder="AGE" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="password" name="pass1" placeholder="PASSWORD" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="password" name="pass2" placeholder="AGREN PASSWORD" class="validate" required>
                        </div>
                        <div ><button class="btn button-default">REGISTER</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end register -->
@endsection
<script src="/js/jquery-1.12.4.min.js"></script>
<script>
    $(function () {
        $('.btn').click(function(){
            var name=$("input[name='name']").val();
            var pass1=$("input[name='pass1']").val();
            var pass2=$("input[name='pass2']").val();
            var age=$("input[name='age']").val();
            var email=$("input[name='email']").val();
            $.ajax({
                url:'/user/regadd',
                data:{'name':name,'pass1':pass1,'pass2':pass2,'age':age,'email':email},
                type:'post',
                dataType:'json',
                success:function (data) {
                    if(data.code==0){
                        alert(data.msg);
                        location.href="/user/login";
                    }else if(data.code==2){
                        alert(data.msg);
                        location.href="/user/login";
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });
        return false;
    });
</script>
