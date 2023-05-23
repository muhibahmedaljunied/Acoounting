
<?php

// namespace C;
require __DIR__.'/autoload.php';

use B\Fruit as FruitB;
use A\Fruit as FruitA;
// --------------------------------------------------------------------------------------------------------------------

$Obj = new FruitB();
$Obj->eat(name:1,age:2,dd:3,ff:4,gg:5);
echo '----------------------------------------------------------------------------------------------------------------------';
$Obj1 = new FruitA();
$Obj1->eat(age:1,name:2,ff:4,gg:5,dd:3,tt:6,ww:7);

// class MainController {

//     /**
//      * @var UserRepository
//      */
//     private $repository;

//     public function __construct(UserRepository $repository)
//     {
//         $this->repository = $repository;
//     }
// }
// class UserRepository {

//     /**
//      * @var Database
//      */
//     private $database;

//     public function __construct(Database $database)
//     {
//         $this->database = $database;
//     }
// }

// class Database {
// }


// class ReflectionResolver
// {
//     /**
//      * @param string $class
//      * @return object
//      * @throws \ReflectionException
//      */
//     public function resolve(string $class)
//     {
//         $reflectionClass = new ReflectionClass($class);

       
//         if (($constructor = $reflectionClass->getConstructor()) === null) {
//             // die($constructor);
//             echo $constructor.'muhib-----1-------';
//             // return $reflectionClass->newInstance();
//         }

//         // die();

//         if (($params = $constructor->getParameters()) === []) {
//             echo $params.'muhib------2------';

//             // return $reflectionClass->newInstance();
//         }

//         $newInstanceParams = [];
//         foreach ($params as $param) {
//             $newInstanceParams[] = $param->getClass() === null ? $param->getDefaultValue() : $this->resolve(
//                 // echo $newInstanceParams.'muhib------3------';

//                 $param->getClass()->getName()
//             );
//         }

//         return $reflectionClass->newInstanceArgs(
//             $newInstanceParams
//         );
//     }
// }

// $resolver = new ReflectionResolver();
// $controller = $resolver->resolve(MainController::class);
// var_dump($controller);



// exit();
