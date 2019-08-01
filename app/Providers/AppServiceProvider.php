<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Blade;

use Illuminate\View\Compilers\BladeCompiler;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	
        Blade::extend(function($view, $compiler) {
            $pattern = $this->createOpenMatcher('spaceless');
            return preg_replace($pattern, '$1<?php ob_start(); ?>$2', $view);
        });

        Blade::extend(function($view, $compiler) {
            $pattern = $this->createOpenMatcher('endspaceless');
            return preg_replace($pattern, '$1<?php echo trim(preg_replace(\'/>\s+</\', \'><\', ob_get_clean())); ?>$2', $view);
        });
    }

    public function createOpenMatcher($function){
        return '/(?<!\w)(\s*)@'.$function.'\(\s*(.*)\)/';
    }
	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
