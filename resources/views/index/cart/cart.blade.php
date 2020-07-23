@extends("index.layouts.layout")
@section("content")

<!-- cart -->
<div class="cart section">
		<div class="container">
			<div class="pages-head">
				<h3>CART</h3>
			</div>
			<div class="content">
				@if($cartInfo!=='')
				@foreach($cartInfo as $v)
				<div class="cart-1">
					<div class="row">
						<div class="col s5">
							<h5>Image</h5>
						</div>
						<div class="col s7">
							<img src="{{$v['goods_img']}}" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Name</h5>
						</div>
						<div class="col s7">
							<h5><a href="">{{$v['goods_name']}}</a></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Quantity</h5>
						</div>
						<div class="col s7"  goods_id="{{$v['goods_id']}}">
							<input value="{{$v['buy_number']}}" type="text" class="buy_number">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Price</h5>
						</div>
						<div class="col s7">
							<h5>${{$v['buy_number']*$v['goods_price']}}</h5>
						</div>
					</div>
					
					<div class="row">
						<div class="col s5">
							<h5>Action</h5>
						</div>
						<div class="col s7" good_id="{{$v['goods_id']}}">
							<h5><i class="fa fa-trash del"></i></h5>
						</div>
					</div>
				</div>
				@endforeach
				@endif
			</div>
			<div class="total">
				<div class="row">
					<div class="col s7">
						<h6>商品总价</h6>
					</div>
					<div class="col s5">
						<h6>${{$money}}</h6>
					</div>
				</div>
			</div>
			<button class="btn button-default">Process to Checkout</button>
		</div>
	</div>
	<!-- end cart -->
	<script src="/static/index/js/jquery.min.js"></script>
	<script>
		//文本框失去焦点
		$(document).on("blur",".buy_number",function(){
			//获取当前失去焦点的文本框
            var _this=$(this);
            //获取购买数量
            var buy_number=_this.val();
			var reg=/^\d{1,}$/;
            //判断购买数量=空
            if(buy_number==""){
                //如果空  文本框赋值1
                _this.val(1);
            }else if(buy_number<=0){
                //小于等于0  文本框赋值1
                _this.val(1);
            }else if(!reg.test(buy_number)){
                //不符合正则  文本框赋值1
                _this.val(1);
            }else{
                _this.val(parseInt(buy_number));
            }
			//获取商品id
			var goods_id=_this.parent().attr("goods_id");
            //更改购买数据
            changeNumber(goods_id,buy_number);
            //重新获取小计
            getTotal(goods_id,_this);
		});
		//更改购买数据
        function changeNumber(goods_id,buy_number){
            $.ajax({
                url:"/changeNumber",
                type:"post",
                data:{goods_id:goods_id,buy_number:buy_number},
                async:false,
                dataType:'json',
                success:function(res){
                    if(res.code==2){
                        console.log(res.font);
                    }
                }
            })
        }
		//重新获取小计
        function getTotal(goods_id,_this){
            $.post(
                "/getTotal",
                {goods_id:goods_id},
                function(res){
                    _this.parents().next().children().children().eq(1).text("$"+res);
                }
            )
        }
		//单删
		
        $(document).on("click",".del",function(){
			if(window.confirm("是否确认删除？")){
            //获取当前点击的对象
            var _this=$(this);
            //获取商品id
            var goods_id=_this.parents('div').attr("good_id");
            $.post(
                "/del",
                {goods_id:goods_id},
                function(res){
                      if(res.code==1){
                          //删除成功
                          _this.parent().parent().parent().parent().remove();
                        //   //获取总价
                        //   getMoney();
                      }else{
                          //删除失败
                          alert(res.font);
                      }
                },"json"
            )
          }  
        })
	</script>
@endsection
