<?php
/**
 * 公用方法
 * @authors Radish (1004622952@qq.com)
 * @date    2020-04-07 15:24 Tuesday
 */

namespace Radish\Uupt\Traits;

use Radish\Network\Curl;

trait Common
{
    use CodeMap;
    /**
     * XML转换成数组
     * @param  xml $xml 
     * @return array
     */
    public function xmlToArray($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 输出xml字符
    **/
    public function arrayToXml(array $array, $time = true)
    {
        $xml = "<xml>";
        if (!isset($array['CreateTime']) && $time) {
            $array['CreateTime'] = time();
        }
        foreach ($array as $key => $val)
        {
            if (is_numeric($val)) {
                $xml .= "<".$key.">".$val."</".$key.">";
            } else if ($key == 'KfAccount') {
                $xml .= "<TransInfo><".$key."><![CDATA[".$val."]]></".$key."></TransInfo>";
            } else {
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml .= "</xml>";

        return $xml;
    }

    /**
      * 获得随机字符串
      * @param $len          需要的长度
      * @param $special      是否需要特殊符号
      * @return string       返回随机字符串
      */
    public function getRandomStr($len = 20, $special = false)
    {
        $chars = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k","l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v","w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        if($special){
            $chars = array_merge($chars, ["!", "@", "#", "$", "?", "|", "{", "/", ":", ";", "%", "^", "&", "*", "(", ")", "-", "_", "[", "]", "}", "<", ">", "~", "+", "=", ",", "."]);
        }
        $charsLen = count($chars) - 1;
        shuffle($chars);  //打乱数组顺序
        $str = '';
        for($i=0; $i<$len; $i++){
            $str .= $chars[mt_rand(0, $charsLen)]; //随机取出一位
        }

        return $str;
    }

    /**
     * 请求响应错误信息
     * @param  json $json 响应数据
     * @param  String $fun 获取对应接口返回错误码信息
     * @return mixed    响应结果
     */
    protected function getMessage($json, $message = '未知错误！')
    {
        $array = json_decode($json, true);
        if (!in_array($array['return_code'], ['ok', 'fail'])) {
            isset($array['return_msg']) && $message = $array['return_msg'];
            $mes = $message == '未知错误！' ? $this->getCodeMap($array['return_code']) : $message;
            throw new \Radish\Uupt\Exception\UuptException($mes, $json);
        } else {
            return $array;
        }
    }

    /**
     * 拼接数组
     * @param  array  $params    待拼接
     * @param  string $connector 拼接符
     * @return string            拼接后字符串
     */
    public function jointString(array $params, $connector = '&')
    {
        ksort($params);
        $d = $string = '';
        foreach ($params as $key => $val) {
            !is_null($val) && $string .= $d . $key . '=' . $val;
            $d = $connector;
        }

        return $string;
    }

    /**
     * 生成订单号
     * @param  string $joint 后缀
     * @return string        返回订单号
     */
    public function orderNo($joint = null)
    {
        if (!$joint) {
            $joint = $this->getRandomStr(5);
        }
        $orderNo = date("YmdHis") . $joint;

        return $orderNo;
    }

    /**
     * 公共的请求接口的方法
     * @param  array  $params 请求参数
     * @param  string $urlKey 请求地址
     * @return mixed          响应结果
     */
    protected function sendResult(array $params, string $urlKey)
    {
        $params['sign'] = strtoupper($this->sign($params));
        $option = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];
        $result = Curl::post($this->getApiUrl($urlKey), $params, $option);

        return $this->getMessage($result);
    }

    /**
     * 生成签名验签
     * @param  Array $params    请求参数
     * @param  string $connector 拼接符
     * @param  string $type      加密方式
     * @return string            加密后字段
     */
    public function sign($params, $connector = '&', $type = 'md5')
    {
        $sign = $this->jointString($params, $connector) . $connector . 'key=' . $this->appKey;
        if ($type == 'md5') {
            $sign = md5(strtoupper($sign));
        }

        return $sign;
    }
}