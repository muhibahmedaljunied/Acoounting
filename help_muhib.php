
<?php 

class A{

    function A_f(){

    }
}
class B{

    function B_f(A $R){

        echo 'muhib';
    }
}

$r = new A();

$e = new B();
$e->B_f($r);
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















   



