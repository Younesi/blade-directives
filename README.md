# PHP Blade Directives

Laravel Custom Blade directives for Laravel Applications.



See https://laravel.com/docs/blade

Installation:

`$ composer require saritasa/blade-directives`


## Available directives:



### @persianNum 
_convert latin numbers to their persian equvalent_

```
@persianNum('Persia 98')
   //will produce "Persia ۹۸"
```

### @action
_check route action_

```
@action('index')
     <p>This is rendered only if route's action is Index.</p>
@endaction
```

or

```
@action('index')
     <p>This is rendered only if route's action is Index.</p>
@elseaction('edit')
     <p>This is rendered only if route's action is Edit.</p>
@else
     <p>This is rendered only if route's action neither is Index nor Edit.</p>
@endaction
```

### @env 
_check app environment_

```
@env('local')
    // The application is in the local environment...
@elseenv('testing')
    // The application is in the testing environment...
@else
    // The application is not in the local or testing environment...
@endenv
```

