@extends('layouts.app')
@section('title', 'pass')
@section('sidebar')
    @parent
@endsection
@section('content')
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>PASS</h3>
            </div>
                <div class="row">
                    <form class="col s12" onsubmit="return false">
                        <div class="input-field">
                            <input type="password" name="pass" class="validate" placeholder="PASSWORD" required>
                        </div>
                        <div class="input-field">
                            <input type="password" name="pass1" class="validate" placeholder="NEW PASSWORD" required>
                        </div>
                        <div class="input-field">
                            <input type="password" name="pass2" class="validate" placeholder="AGAIN NEW PASSWORD" required>
                        </div>
                        <button class="btn button-default">UPDATE</button>
                    </form>
                </div>
        </div>
    </div>
@endsection
<script src="/js/jquery-1.12.4.min.js"></script>
<script>
    $(function () {
        $('.btn').click(function(){
            var pass=$("input[name='pass']").val();
            var pass1=$("input[name='pass1']").val();
            var pass2=$("input[name='pass2']").val();
            $.ajax({
                url:'/user/passupdo',
                data:{'pass':pass,'pass1':pass1,'pass2':pass2},
                type:'post',
                dataType:'json',
                success:function (data) {
                    if(data.code==0){
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