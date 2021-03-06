@extends('layouts.app')

@section('title', '购物车')

@section('content')
<!-- cart -->
<div class="cart section">
    <div class="container">
        <div class="pages-head">
            <h3>购物车</h3>
        </div>
        <div class="content">
            @foreach($cartInfo as $k=>$v)
                <div class="cart-1 goods" gid="{{$v->goods_id}}" gprice="{{$v->self_price}}" >
                    <div class="row">
                        <div class="col s5">
                            <h5>商品图片</h5>
                        </div>
                        <div class="col s7">
                            <a href="/goods/detail/{{$v->goods_id}}"><img src="http://www.lab993.com/uploads/goodsimgs/{{$v->goods_img}}" alt="400px" style="width:300px;height:300px;"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>商品名称</h5>
                        </div>
                        <div class="col s7">
                            <h5><a href="">{{$v->goods_name}}</a></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>购买数量</h5>
                        </div>
                        <div class="col s7">
                            <input value="1" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>商品单价</h5>
                        </div>
                        <div class="col s7">
                            <h5>￥{{$v->self_price}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>删除</h5>
                        </div>
                        <div class="col s7" gid="{{$v->goods_id}}">
                            <h5><i class="fa fa-trash"></i></h5>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
            @endforeach
        </div>
        <div class="total">
        @foreach($cartInfo as $key=>$val)
            <div class="row g" gid="{{$val->goods_id}}" gprice="{{$val->self_price}}">
                <div class="col s7">
                    <h5>{{$val->goods_name}}</h5>
                </div>
                <div class="col s5">
                    <h5>{{$val->self_price}}</h5>
                </div>
            </div>
        @endforeach
            <div class="row">
                <div class="col s7">
                    <h6>总价</h6>
                </div>
                <div class="col s5">
                    <h6 id="total">$0</h6>
                </div>
            </div>
        </div>
        <button class="btn button-default order"  pay_type="1">支付宝结算</button>
        <button class="btn button-default order"  pay_type="2">微信结算</button>
    </div>
</div>
<!-- end cart -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->
<script>
    //总价
    var total=0;
    $.each($(".g"),function(i,v){
        var self_price = $(this).attr('gprice');
        total += parseInt(self_price);
    });
    $("#total").text('￥'+total);

    //删除
    $('.fa-trash').click(function(){
        var _this = $(this);
        var gid = _this.parents('div').attr('gid');
        $.ajax({
            url:'/cart/cartdel/',
            data:{gid:gid},
            type:'post',
            dateType:'json',
            async:true,
            success:function(res){
                if(res.errcode == 0){
                    alert(res.errmsg);
                    _this.parents('div.cart-1').next().remove();
                    _this.parents('div.cart-1').remove();
                    $.each($('.g'),function(i,v){
                        if($(this).attr('gid') == gid){
                            $(this).remove();
                        }
                    });
                    //删除后 总价
                    var newtotal = 0;
                    $.each($(".g"),function(i,v){
                        var self_price = $(this).attr('gprice');
                        newtotal += parseInt(self_price);
                    });
                    $("#total").text('￥'+newtotal);
                }else{
                   alert('errcode:'+res.errcode);
                }
            },
            error:function(){
                alert('出错了');
            }
        })
    })


    // 下单
    $(document).on('click','.order',function(){
        var pay_type = $(this).attr('pay_type');
        var goods_id = '';
        $('.goods').each(function(index){
           goods_id += $(this).attr('gid')+',';
        });

        $.get(
            '/order/create',
            {goods_id:goods_id},
            function(res){
                if(res.errcode == 0){
                    alert(res.msg);
                    if(pay_type == 1){
                        location.href = '/pay?order_no='+res.data.order_no;
                    }else{
                        location.href = '/wechatpay?order_no='+res.data.order_no;
                    }
                }else{
                    alert('下单失败');
                }
            },
            'json'
        );
    });
</script>
@endsection


