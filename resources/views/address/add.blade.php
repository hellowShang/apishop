@extends('layouts.app')
@section('title', 'login')
@section('sidebar')
    @parent
@endsection
@section('content')
    <!-- address -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>ADDRESS</h3>
            </div>
            <div class="register">
                <div class="row">
                    <form class="col s12" onsubmit="return false">
                        <div class="input-field">
                            <input type="text" name="address_name" class="validate" placeholder="ADDRESS NAME" required>
                        </div>
                        <div class="input-field">
                            <input type="tel" name="address_tel" placeholder="ADDRESS TEL" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="checkbox" name="is_status" placeholder="IS STATUS" class="validate" required>
                        </div>
                        <div class="input-field">
                            <select name="province" id="province">
                                <option value="">省份</option>
                                @foreach($arr as $k=>$v)
                                    <option value="{{$v['id']}}">{{$v['name']}}</option>
                                @endforeach
                            </select>
                            <select name="city"  class="city" id="city">
                                <option>城市</option>
                            </select>
                            <select name="area" id="area">
                                <option value="">区县</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <textarea name="address_detailed" id="" cols="30" rows="10" placeholder="ADDRESS DETAILED" class="validate" required></textarea>
                        </div>
                        <div ><button class="btn button-default">ADDRESS ADD</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end address -->
@endsection
<script src="/js/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $('#province').change(function () {
            var id=$(this).val();
            $.ajax({
                url:'/user/getaddress',
                data:{'id':id},
                type:'post',
                dataType:'json',
                success:function (data) {
                    var str="";
                     // str+="<option>城市</option>";
                    $.each(data,function(k,v){
                        str+="<option value="+v.id+">"+v.name+"</option>";
                    });
                    console.log(str);
                    $('#city').after(str);
                }
            });
        });
        $('#area').change(function () {
            var id=$(this).val();
            $.ajax({
                url:'/user/getaddress',
                data:{'id':id},
                type:'post',
                dataType:'json',
                success:function (data) {
                    var str="";
                    $.each(data,function(k,v){
                        str+="<option value="+v.id+">"+v.name+"</option>";
                    });
                    console.log(str);
                    $('.area').html(str);
                }
            });
        });
        $('.btn').click(function(){
            var address_name=$("input[name='address_name']").val();
            var address_tel=$("input[name='address_tel']").val();
            var address_detailed=$("input[name='address_detailed']").val();
            $.ajax({
                url:'/user/addressadd',
                data:{'address_name':address_name,'address_tel':address_tel,'address_detailed':address_detailed},
                type:'post',
                dataType:'json',
                success:function (data) {
                    if(data.code==0){
                        alert(data.msg);
                        location.href="/user/addresslist";
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