<?php

class MyClass
{
    const MY_CONST = 'value'; // A constant

    static $staticVar = 'static';

    // Static variables and their visibility
    public static $publicStaticVar = 'publicStatic';
    private static $privateStaticVar = 'privateStatic';
    protected static $protectedStaticVar = 'protectedStatic';

    // Properties must declare their visibility
    public $property = 'public';
    public $instanceProp;
    protected $prot = 'protected'; // Accessible from the class and subclasses
    private $priv = 'private';   // Accessible within the class only

    /**
     * MyClass constructor.
     * @param string $instanceProp The instance property
     */
    public function __construct(string $instanceProp)
    {
        $this->instanceProp = $instanceProp;
    }

    /**
     * MyMethod prints 'MyClass'
     * @return void
     */
    public function myMethod(): void
    {
        print 'MyClass';
    }

    /**
     * This method cannot be overridden
     * @return void
     */
    final public function youCannotOverrideMe(): void {}

    /**
     * Magic method to convert object to string
     * @return string
     */
    public function __toString(): string
    {
        return $this->property;
    }

    /**
     * Destructor method
     * @return void
     */
    public function __destruct(): void
    {
        print "Destroying";
    }

    /**
     * Static method example
     * @return void
     */
    public static function myStaticMethod(): void
    {
        print 'I am static';
    }
}

// Class constants can always be accessed statically
echo MyClass::MY_CONST;    // Outputs 'value';

echo MyClass::$staticVar;  // Outputs 'static';
MyClass::myStaticMethod(); // Outputs 'I am static';

// Instantiate classes using new
$my_class = new MyClass('An instance property');

// Access class members using ->
echo $my_class->property;     // => "public"
echo $my_class->instanceProp; // => "An instance property"
$my_class->myMethod();        // => "MyClass"

// Nullsafe operators since PHP 8
echo $my_class?->invalid_property; // => NULL
echo $my_class?->invalid_property ?? "public"; // => "public"

// Extend classes using "extends"
class MyOtherClass extends MyClass
{
    /**
     * Prints the protected property
     * @return void
     */
    public function printProtectedProperty(): void
    {
        echo $this->prot;
    }

    /**
     * Override myMethod
     * @return void
     */
    public function myMethod(): void
    {
        parent::myMethod();
        print ' > MyOtherClass';
    }
}

$my_other_class = new MyOtherClass('Instance prop');
$my_other_class->printProtectedProperty(); // => Prints "protected"
$my_other_class->myMethod();               // Prints "MyClass > MyOtherClass"

final class YouCannotExtendMe {}

// Magic methods for getters and setters
class MyMapClass
{
    private $property;

    /**
     * Magic getter method
     * @param string $key The property name
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->$key;
    }

    /**
     * Magic setter method
     * @param string $key The property name
     * @param mixed $value The value to set
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->$key = $value;
    }
}

$x = new MyMapClass();
echo $x->property; // Will use the __get() method
$x->property = 'Something'; // Will use the __set() method

// Interfaces
interface InterfaceOne
{
    public function doSomething(): void;
}

interface InterfaceTwo
{
    public function doSomethingElse(): void;
}

interface InterfaceThree extends InterfaceTwo
{
    public function doAnotherContract(): void;
}

abstract class MyAbstractClass implements InterfaceOne
{
    public $x = 'doSomething';
}

class MyConcreteClass extends MyAbstractClass implements InterfaceTwo
{
    public function doSomething(): void
    {
        echo $this->x;
    }

    public function doSomethingElse(): void
    {
        echo 'doSomethingElse';
    }
}

class SomeOtherClass implements InterfaceOne, InterfaceTwo
{
    public function doSomething(): void
    {
        echo 'doSomething';
    }

    public function doSomethingElse(): void
    {
        echo 'doSomethingElse';
    }
}

// Traits
trait MyTrait
{
    public function myTraitMethod(): void
    {
        print 'I have MyTrait';
    }
}

class MyTraitfulClass
{
    use MyTrait;
}

$cls = new MyTraitfulClass();
$cls->myTraitMethod(); // Prints "I have MyTrait"

// Namespaces (example in comments)
// namespace My\Namespace;
// 
// class MyClass
// {
// }
// 
// // (from another file)
// $cls = new My\Namespace\MyClass;
// 
// // Or from within another namespace.
// namespace My\Other\Namespace;
// 
// use My\Namespace\MyClass;
// 
// $cls = new MyClass();
// 
// // Or you can alias the namespace;
// 
// namespace My\Other\Namespace;
// 
// use My\Namespace as SomeOtherNamespace;
// 
// $cls = new SomeOtherNamespace\MyClass();

// Late Static Binding
class ParentClass
{
    public static function who(): void
    {
        echo "I'm a " . __CLASS__ . "\n";
    }

    public static function test(): void
    {
        self::who();
        static::who();
    }
}

ParentClass::test();
/*
I'm a ParentClass
I'm a ParentClass
*/

class ChildClass extends ParentClass
{
    public static function who(): void
    {
        echo "But I'm " . __CLASS__ . "\n";
    }
}

ChildClass::test();
/*
I'm a ParentClass
But I'm ChildClass
*/

// Magic constants
echo "Current class name is " . __CLASS__ . "\n";
echo "Current directory is " . __DIR__ . "\n";
echo "Current file path is " . __FILE__ . "\n";
echo "Current function name is " . __FUNCTION__ . "\n";
echo "Current line number is " . __LINE__ . "\n";
echo "Current method is " . __METHOD__ . "\n";
echo "Current namespace is " . __NAMESPACE__ . "\n";
echo "Current trait is " . __TRAIT__ . "\n";

// Error Handling
try {
    // Do something
} catch (\Exception $e) {
    // Handle exception
}

// Custom exceptions
class MyException extends Exception {}

try {
    $condition = true;
    if ($condition) {
        throw new MyException('Something just happened');
    }
} catch (MyException $e) {
    // Handle my exception
}
