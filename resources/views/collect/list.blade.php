@extends('layouts.app')

@section('title', '收藏')

@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- cart -->
    <div class="cart section">
        <div class="container">
            <div class="pages-head">
                <h3>收藏</h3>
            </div>
            @if($collectInfo == "[]")
                    <h1 style="color:red;">暂无收藏</h1>
            @else
            @foreach($collectInfo as $k=>$v)
            <div class="content">
                <div class="cart-1">
                    <div class="row">
                        <div class="col s5">
                            <h5>Image</h5>
                        </div>
                        <div class="col s7" style="width:200px;height:200px;">
                            <img src="http://www.lab993.com/uploads/goodsimgs/{{$v->goods_img}}" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Name</h5>
                        </div>
                        <div class="col s7">
                            <h5><a href="">{{$v->goods_name}}</a></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Price</h5>
                        </div>
                        <div class="col s7">
                            <h5>${{$v->self_price}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Action</h5>
                        </div>
                        <div class="col s7">
                            <h5><i class="fa fa-trash delete" goods_id="{{$v->goods_id}}"></i></h5>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <!-- end cart -->

    <!-- loader -->
    <div id="fakeLoader"></div>
    <!-- end loader -->
    <script>
        $(function(){
            $(document).on('click','.delete',function(){
                var goods_id = $(this).attr('goods_id');
                $.get(
                    'delcollect',
                    {goods_id:goods_id},
                    function(res){
                        alert(res.msg);
                        history.go(0);
                    },
                    'json'
                );
            });
        })
    </script>
@endsection