# PHP Blade Directives

Laravel Custom Blade directives for Laravel Applications.


See https://laravel.com/docs/blade

Installation:

`$ composer require younesi/blade-directives`


## Available directives:


### @persianNum 
_convert latin numbers to their persian equvalent_

```
@persianNum('Persian Numbers 9123456780 اعداد فارسی')
   //will produce "Persian Numbers ۹۱۲۳۴۵۶۷۸۰ اعداد فارسی"
```

### @isTrue
_Only show when $variable isset and true_

```
@isTrue($variable)
   This will be echoed
@endisTrue
```

### @isFalse
_Same as @istrue but checks for isset and false_

```
@isFalse($variable)
   if $variable is False hhis will be echoed
@endisFalse
```

### @isNull
_Only show when $variable is null_

```
@isNull($variable)
   This will be echoed
@endisNull
```

### @isNotNull
_Same as @isnull but one shows when $variable is not null_

```
@isNotNull($variable)
   This will be echoed
@endIsNotNull
```

### @dd 
```
@dd($var)
```

### @dump 
```
@dump($var)
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

