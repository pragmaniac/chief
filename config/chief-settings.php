<?php

return [

    /**
     * Homepage id
     *
     * Here you can explicitly set the page that is considered to be the website homepage,
     * This page is always retrieved via the root url and does not have an own url.
     * If value is left empty, the first published page is used as a default.
     *
     * e.g. 'homepage' => 2,
     */
    'homepage' => null,

    /**
     * Contact person (aka webmaster)
     *
     * The contact person receives all incoming communication e.g. contact form submissions
     * and is the sender address for all transaction mails such as password reset mails.
     */
    'contact' => [
        'email' => env('MAIL_ADMIN_EMAIL', 'info@thinktomorrow.be'),
        'name'  => env('MAIL_ADMIN_NAME', 'Think Tomorrow'),
    ],

    /**
     * Client details
     *
     * This is mainly a backend thing but it can occur in a
     * couple of frontend places such as the mail footer.
     */
    'client' => [
        'name' => 'Think Tomorrow',
        'app_name' => 'Chief',
    ],

    /**
     * Admin language
     *
     * Change the language of the admin panel. The translations will be published to the
     * resources/lang/vendor. Feel free to add any language you need there
     * or make a PR so we can add it to the core.
     */
    'admin_locale' => 'en',
    
    'admin_fallback_locale' => 'nl',
];
