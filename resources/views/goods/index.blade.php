@extends('layouts.app')

@section('title', '全部商品')

@section('sidebar')
    @parent
@endsection

@section('content')

	<!-- product -->
	<div class="section product product-list">
		<div class="container">
			<div class="pages-head">
				<h3>商品列表</h3>
			</div>
			<div class="input-field">
				<select>
					<option value="">Popular</option>
					<option value="1">New Product</option>
					<option value="2">Best Sellers</option>
					<option value="3">Best Reviews</option>
					<option value="4">Low Price</option>
					<option value="5">High Price</option>
				</select>
			</div>
			
			<div class="row">
				@foreach($list as $k=>$v)	
				<div class="col s6" >				
					<div class="content">
						<a href='/goods/detail/{{$v->goods_id}}'><img src="http://www.lab993.com/uploads/goodsimgs/{{$v->goods_img}}" alt="" style="width:300px;height:300px;"></a>
						<h6><a href="/goods/detail/{{$v->goods_id}}"><span>{{$v->goods_name}}</span></a></h6>
						<div class="price">
							价格：￥{{$v->self_price}} <span>￥{{$v->market_price}}</span>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;库存：<b>{{$v->goods_score}}</b>
						</div>
						<button class="btn button-default goods" gid="{{$v->goods_id}}" >加入购物车</button>
						<button class="btn button-default collect" goods_id="{{$v->goods_id}}">收藏</button>
					</div>
					<div class="col s6"></div></br>					
				</div>	
				@endforeach		
			</div>
			
			<div class="row margin-bottom">
			<div class="pagination-product">
				<ul>
						{{$list->links()}}
				
				</ul>
			</div>
			<br>
		</div>
	</div>

	</div>
	<script>
        $(".goods").click(function(){
            var _this = $(this);
            var gid = _this.attr('gid');
            $.ajax({
                url:'/cart/cartadd/',
                data:{gid:gid},
                type:'post',
                dateType: 'json',
                async:true,
                success:function(res){
                    if(res.errcode == 0){
                        alert(res.errmsg);
                    }else{
                        alert('error:'+res.errcode);
                    }
                },
                error:function(){
                    alert('您还没有登录，请先登录');
                    location.href='/user/login';
                }
            })
        });
        // 收藏
        $(document).on('click','.collect',function(){
            var goods_id = $(this).attr('goods_id');
            $.post(
                '/collect',
                {goods_id:goods_id},
                function(res){
                    alert(res.msg)
                },
                'json'
            );
        });
	</script>
 @endsection
