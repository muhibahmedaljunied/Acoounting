
<?php

interface A_interface
{

    public function A_f();
}

interface B_interface
{

    public function B_f();
}

abstract class z
{

    public $dw = 0;
    public function z_f()
    {
        echo 'muhib in A_interface of class A';
    }


    abstract function za_f();
}

class A extends z implements A_interface
{

    public function A_f()
    {
        echo 'muhib in A_interface of class A';
        echo '--------------------------------------------------------------------------';
    }

    public function za_f()
    {
        echo 'muhib in za_f of class A that extends abstract';
        echo '--------------------------------------------------------------------------';
    }
}
class B extends z implements A_interface
{

    public function A_f()
    {
        echo 'muhib in A_interface of class B';
        echo '--------------------------------------------------------------------------';
    }

    public function za_f()
    {
        echo 'muhib in za_f of class B that extends abstract';
        echo '--------------------------------------------------------------------------';
    }
}

class Core
{


    function A(A_interface $a)
    {


        $a->A_f();
    }

    function B(z $x)
    {


        echo $x->dw;
        $x->za_f();
    }

    // ----------------------------------

}


$a = new A();
$b = new B();
$e = new Core();
$e->A($a);
echo '---------------------------------------',
$e->B($b);


// -----------------------------------------------------------------------------Facades-----------------------------------------------------------------------------
// 1-Facades provide a "static" interface to classes that are available in the application's service container.
// 2-Laravel's facades are defined in the Illuminate\Support\Facades namespace. 
// 3-In a Laravel application, a facade is a class that provides access to an object from the container
// 4-some care must be taken when using facades. The primary danger of facades is class "scope creep"


// <!-- ------------------------------------------------------ServiceProviders----------------------------------------------------------------------------------------- -->

// Service provider is the main file that connects our package with laravel app. Using this class you load following things in laravel app.
//     -You can add migrations
//     -You can add translations
//     -You can merge configurations
//     -You can define routes
//     -You can load more classes and many other things

// https://www.youtube.com/watch?v=lTO8Pq_kYzM&list=PL7mt2FDjAkPem0qTCu8cNLd25-RTD7i5Q      advanced js



// The container gives you the opportunity to define bindings to classes and interfaces. At the same time, 
// it has a unique feature known as Zero Configuration Resolution that makes the container resolve dependencies without even registering them
