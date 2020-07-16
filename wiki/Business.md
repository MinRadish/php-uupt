# UU跑腿订单

- see [官方文档](http://open.uupt.com/Doc/developword.html)


### 计算订单价格

**示例代码**

~~~
$uupt = new Uupt;
$params = [
    // 'origin_id' => trim(['order.trade_no']),
    'from_address' => $data['from_address'],
    'to_address' => $data['to_address'],
    'city_name' => $data['city_name'],
    'send_type' => '0',
    'to_lat' => $data['to_lat'],
    'to_lng' => $data['to_lng'],
    'from_lat' => $data['from_lat'],
    'from_lng' => $data['from_lng'],
];
$resule = $uupt->getOrderPrice($params);
~~~

### 创建订单

**示例代码**

~~~
$uupt = new Uupt;
$params = [
    'price_token' => $data['price_token'],
    'order_price' => $data['total_money'],
    'balance_paymoney' => $data['need_paymoney'],
    'receiver' => $data['city_name'],
    'callback_url' => 'http://api.****.com/api/OrderUupt/notify',
    'receiver_phone' => $data['receiver_phone'],
    'push_type' => 0, // 推送方式（0 开放订单，2测试订单）默认传0即可
    'special_type' => '0', // 特殊处理类型，是否需要保温箱 1需要 0不需要
    'callme_withtake' => '0', // 取件是否给我打电话 1需要 0不需要
];
$resule = $uupt->created($params);
~~~

### 取消订单

**示例代码**

~~~
$uupt = new Uupt;
$params = [
    'order_code' => $data['trade_no'],
    'reason' => $data['reason'],
];
$resule = $uupt->cancel($params);
~~~

### 查询订单

**示例代码**

~~~
$uupt = new Uupt;
$params = [
    'order_code' => $data['trade_no'],
    // 'origin_id' => trim($data['id']),
];
$resule = $uupt->select($params);
~~~

### 回调

**示例代码**

~~~
$uupt = new Uupt;
$input = json_decode($inputData, true);
$input = $input ?: [];
$checkSign = $uupt->notify($input);
~~~
