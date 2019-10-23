
<html>
<head>
    <title>核销订单</title>
    <script src="{{asset('plugins/jquery/jquery.js')}}" type="text/javascript" charset="utf-8"></script>

</head>
<body>

<div class="container">
    <p>
        <h4>
            乐众小店订单核销
        </h4>
    </p>
    <p>
        <h5>
            订单编号：{{$order->no}}
        </h5>
    </p>
    <p>
        <h5>
            订单总金额：{{$order->total_amount}}
        </h5>
    </p>
    <p>
        <h5>订单内容：</h5>
    @foreach($order->items as $k => $v)
        <p style="font-size: 14px">
            商品{{$k+1}}
        </p>
        <p style="font-size: 14px">
            商品名称：{{ $v['product_name'] }}
        </p>
        <p style="font-size: 14px">
            规格：{{ $v['title'] }}
        </p>
        <p style="font-size: 14px">
            数量：{{ $v['amount'] }}
        </p>
        <p style="font-size: 14px">
            单价：{{ $v['price'] }}
        </p>
    @endforeach
    </p>
        <div style="height: 30px;width: 120px;border: 1px solid #CCCCCC;border-radius: 10px;margin: auto;text-align: center;" onclick="$check('{{$order->id}}')">
            <span style="line-height: 30px;">
                核销订单
            </span>
        </div>
</div>
</body>
<script>
    $check = function (id) {
        $.ajax({
            data: {
                id: id
            },
            type: "POST",
            dataType: "json",
            url: 'https://api.jiangsulezhong.com/weapp/order/confirm-check',
            success: function (res) {
                console.log(res)
            },
            error: function () {
                layer.close(ind)
                layer.msg("啊哟喂~出错了，再试一次看看呢！");
            },
        });
    }
</script>
<style>
    p{
        margin-bottom: -10px;
    }
</style>
</html>
