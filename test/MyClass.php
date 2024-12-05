<?php
// 类名用大驼峰命名法，类的名字和文件名字一致
class MyClass
{
    /*属性 */
    /*静态属性 */
    public static $school = 'sziit';
    const ADDRESS = '龙翔大道2188号';
    protected static $name = '张三';
    /* 方法 */
    /* 静态方法 */
    public static function showData()
    {
        echo self::$name;
        echo self::$school;
        echo self::ADDRESS;
    }
    public function publicData()
    {
        $this->showData();
        self::showData();
    }
    public static function usePublic()
    {
        //self::publicData();
        //在静态方法中，不可以调用非静态方法
        // $this->publicData();
    }
}

/*类成员调用 */
// 错误示范
echo(new Myclass)->school;
echo(new Myclass)->ADDRESS;
//致命错误，在外部访问受保护属性

// 正确示范
echo Myclass::$school;
echo Myclass::ADDRESS;

// 虽然正确，但不建议
(new MyClass)->showData();
MyClass::showData();
(new MyClass)->publicData();