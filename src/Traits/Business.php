<?php
/**
 * 业务
 * @authors Radish (1004622952@qq.com)
 * @date    2020-04-07 18:05 Tuesday
 */

namespace Radish\Uupt\Traits;

trait Business
{
    /**
     * 格式化请求参数
     * @param  array  $params    请求参数
     * @return array             响应结果
     */
    public function formatParams(array $options)
    {
        $params = [
            'appid' => $this->appId,
            'openid' => $this->openId,
            'nonce_str' => $this->getRandomStr(),
            'timestamp' => time(),
        ];
        return $params = array_merge($params, $options);
    }

    /**
     * 计算订单价格
     * @param  array  $params    请求参数
     * @return array             响应结果
     */
    public function getOrderPrice(array $options)
    {
        $params = $this->formatParams($options);

        return $this->sendResult($params, 'get_order_price');
    }

    /**
     * 创建订单
     * @param  array  $params    请求参数
     * @return array             响应结果
     */
    public function created(array $options)
    {
        $params = $this->formatParams($options);

        return $this->sendResult($params, 'created_order');
    }

    /**
     * 取消订单
     * @param  array  $params    请求参数
     * @return array             响应结果
     */
    public function cancel(array $options)
    {
        $params = $this->formatParams($options);

        return $this->sendResult($params, 'cancel_order');
    }

    /**
     * 查询订单
     * @param  array  $params    请求参数
     * @return array             响应结果
     */
    public function select(array $options)
    {
        $params = $this->formatParams($options);

        return $this->sendResult($params, 'select_order');
    }

    /**
     * 查询订单
     * @param  array  $params    请求参数
     * @return array             响应结果
     */
    public function notify(array $params)
    {
        $sign = strtoupper($params['sign']);
        unset($params['sign']);
        $newSign = strtoupper($this->notifySign($params));
        if ($sign === $newSign) {
            return $params;
        } else {
            return false;
        }
    }

    protected function notifySign($params)
    {
        ksort($params);
        $d = $string = '';
        $connector = '&';
        foreach ($params as $key => $val) {
            (!is_null($val) && $val) && $string .= $d . $key . '=' . $val;
            $d = $connector;
        }
        $sign = $string . $connector . 'key=' . $this->appKey;
        $sign = md5(strtoupper($sign));

        return $sign;
    }
    
}