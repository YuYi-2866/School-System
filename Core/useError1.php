<?php

// use edu\error\Error2;
// use edu\exception\Error2 as MyErr2;

require './Error1.php';
// require './Error2.php';

// 未定义命名空间
// (new Error1)->error();
// 已定义命名空间
// (new \edu\error\Error2)->error();
//使用use引入命名空间后的调用格式
// (new Error2)->error();

/* 如果有重名的类，\edu\exception\Error2 */
//(new edulexception\Error2)->error();
// (new MyErr2)->error();