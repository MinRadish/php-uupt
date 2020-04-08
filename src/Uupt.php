<?php
/**
 * 
 * @authors Radish (1004622952@qq.com)
 * @date    2020-04-07 15:24 Tuesday
 */

namespace Radish\Uupt;

abstract class Uupt
{
    protected $appId = '';
    protected $appKey = '';
    protected $openId = '';
    protected $url = 'https://openapi.uupt.com/v2_0/';

    use Traits\Common;
    use Traits\Business;

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $val) {
            if ($val && property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }
}