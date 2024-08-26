<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
            'api/projects',
            'api/contacts',
            'api/likes/create',
            'api/likes/delete',
            'api/likes/count',
            'api/alluser'
    ];
}

