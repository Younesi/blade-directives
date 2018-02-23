<?php

namespace Younesi\BladeDirectives;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        collect(get_class_methods(static::class))->map(function ($item) {
            if (starts_with($item, 'extend')) {
                $this->registerDirectives($item);
            }
            if (starts_with($item, 'if')) {
                $this->registerIfDirectives($item);
            }
        });
    }

    /**
     * Parse expression.
     *
     * @param  string $expression
     * @return \Illuminate\Support\Collection
     */
    private function multipleArgs($expression)
    {
        return collect(explode(',', $expression))->map(function ($item) {
            return trim($item);
        });
    }

    /**
     * Strip single quotes.
     *
     * @param  string $expression
     * @return string
     */
    private function stripQuotes($expression)
    {
        return str_replace("'", '', $expression);
    }

    /**
     * Start registration all blade directives.
     *
     * @param  string   $method
     */
    private function registerDirectives($method)
    {
        $directive = camel_case(str_replace('extend', '', $method));

        Blade::directive($directive, function($expression) use($method) {
            return $this->{$method}($expression);
        });
    }

    /**
     * Start registration all blade directives.
     *
     * @param  string   $method
     */
    private function registerIfDirectives($method)
    {
        $directive = strtolower(str_replace('if', '', $method));

        Blade::if($directive, function($expression) use($method) {
            return $this->{$method}($expression);
        });
    }

    /**
     * Create a HTML element to your Laravel-Mix css or js.
     *
     * @param $expression
     * @return string
     */
    protected function extendMix($expression)
    {
        if (ends_with($expression, ".css'")) {
            return '<link rel="stylesheet" href="<?php echo mix('.$expression.') ?>">';
        }
        if (ends_with($expression, ".js'")) {
            return '<script src="<?php echo mix('.$expression.') ?>"></script>';
        }
        return "<?php echo mix({$expression}); ?>";
    }

    /**
     * Create a <style> element or <link> element with a css path.
     *
     * @param $expression
     * @return string
     */
    protected function extendStyle($expression)
    {
        if (! empty($expression)) {
            return '<link rel="stylesheet" href="'.$this->stripQuotes($expression).'">';
        }
        return '<style>';
    }

    /**
     * Create a </style> element with a css.
     *
     * @param $expression
     * @return string
     */
    protected function extendEndStyle($expression)
    {
        return '</style>';
    }

    /**
     * Create a <script> element with or without a js path.
     *
     * @param  $expression
     * @return string
     */
    protected function extendScript($expression) {
        if (! empty($expression)) {
            return '<script src="'.$this->stripQuotes($expression).'"></script>';
        }
        return '<script>';
    }

    /**
     * Create a </script> element with or without a js path.
     *
     * @param  $expression
     * @return string
     */
    protected function extendEndScript($expression) {
        return '</script>';
    }

    /**
     * Load the contents of a css or js file inline in your view.
     *
     * @param $expression
     * @return string
     */
    protected function extendInline($expression)
    {
        $include = "//  {$expression}\n"."<?php include public_path({$expression}) ?>\n";
        if (ends_with($expression, ".html'")) {
            return $include;
        }
        if (ends_with($expression, ".css'")) {
            return "<style>\n".$include.'</style>';
        }
        if (ends_with($expression, ".js'")) {
            return "<script>\n".$include.'</script>';
        }
    }

    /**
     * Repeat something a specified amount of times.
     *
     * @param $expression
     * @return string
     */
    protected function extendRepeat($expression)
    {
        return "<?php for (\$iteration = 0 ; \$iteration < (int) {$expression}; \$iteration++): ?>";
    }

    /**
     * Repeat something a specified amount of times.
     *
     * @param $expression
     * @return string
     */
    protected function extendEndRepeat($expression) {
        return '<?php endfor; ?>';
    }

    /**
     * Quickly output a Font Awesome icon.
     *
     * @param $expression
     * @return string
     */
    protected function extendFa($expression)
    {
        $expression = $this->stripQuotes($expression);
        return '<i class="fa fa-'.$expression.'"></i>';
    }

    /**
     * get route url.
     *
     * @param $expression
     * @return string
     */
    protected function extendRoute($expression)
    {
        return "<?php echo route($expression) ?>";
    }

    /**
     * Convert to persian numbers in a string.
     *
     * @param $expression
     * @return string
     */
    protected function extendFarsiNum($expression)
    {
         $array = [ '0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴',
                        '5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹'
            ];
           $converted =  strtr($expression, $array);
           return "<?php echo $converted; ?>";
    }


    /**
     * Generate a url for the application..
     *
     * @param $expression
     * @return string
     */
    protected function extendUrl($expression)
    {
        return "<?php echo url($expression) ?>";
    }

    /**
     * Create a href attr with route.
     *
     * @param $expression
     * @return string
     */
    protected function extendHrefRoute($expression)
    {
        return "<?php echo 'href=\"'.route($expression).'\"'; ?>";
    }

    /**
     * Create a action attr with route.
     *
     * @param $expression
     * @return string
     */
    protected function extendActionRoute($expression)
    {
        return "<?php echo 'action=\"'.route($expression).'\"'; ?>";
    }

    /**
     * Create a href attr with url.
     *
     * @param $expression
     * @return string
     */
    protected function extendHrefUrl($expression)
    {
        return "<?php echo 'href=\"'.url($expression).'\"'; ?>";
    }

    /**
     * Create a action attr with url.
     *
     * @param $expression
     * @return string
     */
    protected function extendActionUrl($expression)
    {
        return "<?php echo 'action=\"'.url($expression).'\"'; ?>";
    }

    /**
     * Generate an asset path for the application.
     *
     * @param $expression
     * @return string
     */
    protected function extendAsset($expression)
    {
        return "<?php echo asset($expression) ?>";
    }

    /**
     * Create a action attr with asset.
     *
     * @param $expression
     * @return string
     */
    protected function extendHrefAsset($expression)
    {
        return "<?php echo 'href=\"'.asset($expression).'\"'; ?>";
    }

    /**
     * Create a action attr with asset.
     *
     * @param $expression
     * @return string
     */
    protected function extendActionAsset($expression)
    {
        return "<?php echo 'action=\"'.asset($expression).'\"'; ?>";
    }

    /**
     * Only show when variable true.
     *
     * @param $expression
     * @return bool
     */
    protected function ifIsTrue($expression)
    {
        return ($expression === true);
    }

    /**
     * Only show when variable false.
     *
     * @param $expression
     * @return bool
     */
    protected function ifIsFalse($expression)
    {
        return ($expression === false);
    }

    /**
     * Only show when variable null.
     *
     * @param $expression
     * @return bool
     */
    protected function ifIsNull($expression)
    {
        return is_null($expression);
    }

    /**
     * Only show when variable not null.
     *
     * @param $expression
     * @return bool
     */
    protected function ifIsNotNull($expression)
    {
        return ! is_null($expression);
    }

     /**
     * Only show when app environment is equal
     *
     * @param $expression
     * @return bool
     */
    protected function ifEnv($environment)
    {
         return app()->environment($environment);
    }

    /**
     * If yroute action evalutes to true
     *
     * @param $expression
     * @return bool
     */
     protected function ifAction($action)
    {
        return (Route::getCurrentRoute()->getActionMethod() == $action);
    }
}