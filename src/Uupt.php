<?php
/**
 * 
 * @authors Radish (1004622952@qq.com)
 * @date    2020-04-07 15:24 Tuesday
 */

namespace Radish\Uupt;

abstract class Uupt
{
    protected static $mchId = '';
    protected static $appId = '';

    use Traits\Common;
    use Traits\Business;

    public function __construct(array $options = [])
    {
        
    }
}