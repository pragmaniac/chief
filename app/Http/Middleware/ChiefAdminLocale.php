<?php

namespace Thinktomorrow\Chief\App\Http\Middleware;

use Closure;

class ChiefAdminLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app()->setLocale(config('thinktomorrow.chief-settings.admin_locale'));
        config(['translatable.fallback_locale' => config('thinktomorrow.chief-settings.admin_fallback_locale')]);
        config(['translatable.use_fallback' => true]);
        $adminTranslations = [
            'chief::audit',
            'chief::nav',
            'chief::components',
            'chief::dashboard',
            'chief::errorpage',
            'chief::mails',
            'chief::managers',
            'chief::menu',
            'chief::modules',
            'chief::pages',
            'chief::permissions', 
            'chief::roles'
        ];
        $excludedFiles = array_merge(config('squanto.excluded_files'), $adminTranslations);
        config(['squanto.excluded_files' => $excludedFiles]);

        return $next($request);
    }
}
