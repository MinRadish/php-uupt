<?php
/**
 * 错误码映射
 * @authors Radish (1004622952@qq.com)
 * @date    2020-04-07 18:05 Tuesday
 */

namespace Radish\Uupt\Traits;

trait CodeMap
{
    /**
     * 获取请求连接
     * @param  string $key 连接类型
     * @return string      请求地址
     */
    protected function getApiUrl($key)
    {
        $urlMap = [
            //POST 计算订单价格
            'get_order_price' => 'getorderprice.ashx',
            //POST 创建订单
            'created_order' => 'addorder.ashx',
            //POST 取消订单
            'cancel_order' => 'cancelorder.ashx',
            //POST 查询订单
            'select_order' => 'getorderdetail.ashx',
        ];

        return $this->url . $urlMap[$key];
    }

    /**
     * 获取错误代码
     * @param  string $key 代码
     * @return String 错误代码与信息
     */
    protected function getCodeMap($key)
    {
        $codeMap = [
            '-101' => '参数格式校验错误',
            '-102' => 'timestamp错误',
            '-103' => 'appid无效',
            '-104' => '签名校验失败',
            '-105' => 'openid无效',
            '-199' => '参数格式校验错误',
            '-1001' => '无法解析起始地',
            '-1002' => '无法解析目的地',
            '-1003' => '无法获取订单城市相关信息',
            '-1004' => '订单小类出现错误',
            '-1005' => '没有用户信息',
            '-1006' => '优惠券ID错误',
            '-2001' => 'price_token无效',
            '-2002' => 'price_token无效',
            '-2003' => '收货人电话格式错误',
            '-2004' => 'special_type错误',
            '-2005' => 'callme_withtake错误',
            '-2006' => 'order_price错误',
            '-2007' => 'balance_paymoney错误',
            '-2008' => '订单总金额错误',
            '-2009' => '支付金额错误',
            '-2010' => '用户不一致',
            '-2011' => '手机号错误',
            '-2012' => '不存在绑定关系',
            '-4001' => '取消原因不能为空',
            '-4002' => '订单编号无效',
            '-5001' => '订单编号无效',
            '-5002' => '订单编号无效',
            '-5003' => '订单编号无效',
            '-10001' => '发送频率过快，请稍候重试',
            '-11001' => '请输入正确的验证码',
        ];
        $info = isset($codeMap[$key]) ? $codeMap[$key] : false;

        return $info;
    }
}