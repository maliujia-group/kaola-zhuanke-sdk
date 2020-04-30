**考拉赚客SDK**

考拉赚客SDK，基于在线文档 

https://www.kdocs.cn/l/shwrmIbwm?f=101

PHP =>7.0

### 使用示例

```php
$config = [
    'appSecret' => '', // 密钥
    'unionId' => '', // 联盟ID
];
$client = new \KlZkSdk\KlZkFatory($config);
$result = $client->order->byOrderId('123123123');
if ($result == false ) {
    var_dump($client->getError());
}
var_dump($result);
```
