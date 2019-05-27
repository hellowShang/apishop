@extends('layouts.app')

@section('title', '订单列表')

@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- shop single -->
    <div class="pages section">
            @if($orderInfo == "[]")
                <div class="container">
                    <div class="shop-single">
                        <h1 style="color: red;">暂时没有订单呢,赶快下单吧，亲！！！</h1>
                    </div>
                </div>
            @else
            <div class="container">
                 @foreach($orderInfo as $k=> $v)
                    <div class="shop-single">
                        <img src="http://www.lab993.com/uploads/goodsimgs/{{$v->goods_img}}" style="width:300px;height:300px; border:1px solid #0b0b0b;">
                        <h5>{{$v->goods_name}}</h5>
                        <div class="price">${{$v->self_price}} <span>${{$v->market_price}}</span></div>
                        <p>{{$v->goods_desc}}</p>
                        <button type="button" class="btn button-default oid" oid="{{$v->id}}">删除订单</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- end shop single -->
    <script src="http://client.lab993.com/js/jquery.js"></script>
    <script>
        $(function(){
            $(document).on('click','.oid',function(){
                var _this = $(this);
                var oid = $(this).attr('oid');
                $.get(
                    '/order/deleteOrder',
                    {oid:oid},
                    function(res){
                       alert(res.msg);
                       if(res.num == 1){
                            _this.parent().remove();
                       }
                    },
                    'json'
                );
            });
        });
    </script>
@endsection