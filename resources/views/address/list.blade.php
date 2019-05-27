@extends('layouts.app')
@section('title', 'addresslist')
@section('sidebar')
    @parent
@endsection
@section('content')
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>ADDRESSLIST</h3>
            </div>
            <div class="row">
                <table border="1" class="pages-head container">
                    <tr>
                        <td>姓名</td>
                        <td>电话</td>
                        <td>详细地址</td>
                        <td>省</td>
                        <td>市</td>
                        <td>区</td>
                        <td>加入时间</td>
                        <td>操作</td>
                    </tr>
                    @foreach($data as $k=>$v)
                    <tr>
                        <td>{{$v['address_name']}}</td>
                        <td>{{$v['address_tel']}}</td>
                        <td>{{$v['address_detailed']}}</td>
                        <td>{{$v['province']}}</td>
                        <td>{{$v['city']}}</td>
                        <td>{{$v['area']}}</td>
                        <td>{{date('Y-m-d H:i:s',$v['address_time'])}}</td>
                        <td>
                            <button class="sc">删除</button>
                            <input type="hidden" name="address_id" value="{{$v['address_id']}}">
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
<script src="/js/jquery-1.12.4.min.js"></script>
<script>
    $(function () {
        $('.sc').click(function(){
            var address_id=$(this).next().val();
            $.ajax({
                url:'/user/addressdel',
                data:{'address_id':address_id},
                type:'post',
                dataType:'json',
                success:function (data) {
                    if(data.code==0){
                        alert(data.msg);
                        location.href="/user/addresslist";
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });
        $('.xg').click(function(){
            var address_id=$(this).next().val();
            $.ajax({
                url:'/user/addressup',
                data:{'address_id':address_id},
                type:'post',
                dataType:'json',
                success:function (data) {

                }
            });
        });
        return false;
    });
</script>