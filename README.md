## fmblog-backend-form

This module supports backend for fmblog-frontend-form.

**Required packages**
*--no required packages--*

**Required Modules**
1. Laravel-Module-Core

**Functionalities**
1. View the submitted forms

**Installation**
1. Add the module to Laravel project as a submodule. 
`git submodule add https://github."/bwqr/fmblog-backend-form app/Modules/Form`
2. Add the route file `Http/form.php` to `app/Providers/RouteServiceProvider.php`
 and register inside the `map` function, eg.  
 `
    protected function mapFormRoutes()
    {
        Route::prefix('api/form')
            ->middleware('api')
            ->namespace($this->moduleNamespace . "\Form\Http\Controllers")
            ->group(base_path('app/Modules/Form/Http/forms.php'));
    }
 `
