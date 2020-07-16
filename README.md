# php-uupt

    PHP 对UU跑腿接口的调用

*需自定义一个类并继承 Radish\Uupt\Uupt重写构造函数进行相关配置*

~~~
<?php
/**
 * UU跑腿
 * @authors 
 * @date    
 */
namespace common\helper;

class Uupt extends \Radish\Uupt\Uupt
{
    public function __construct(array $options = [])
    {
        if (!$options) {
            $options = config('uupt.'); //thinkphp5.1 config函数
        }
        parent::__construct($options);
    }
}
~~~
