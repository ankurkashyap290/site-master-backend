<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * @SuppressWarnings(PHPMD.Superglobals)
 */
if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

class JourneyScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     *
     * @SuppressWarnings("unused")
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = auth()->user();

        if (!is_null($user)) {
            $headers = getallheaders();
            $scopes = [];
            if (!empty($headers['Journey-Scopes'])) {
                $scopes = explode('&', $headers['Journey-Scopes']);
            } elseif (!empty($headers['journey-scopes'])) { // mobile SDKs force lowercase
                $scopes = explode('&', $headers['journey-scopes']);
            }

            foreach ($scopes as $scope) {
                list($key, $value) = explode('=', $scope);
                if ($key === 'facility_id' && !$user->facility_id) {
                    $relatedFacilities = $user->getRelatedFacilities();
                    foreach ($relatedFacilities as $facility) {
                        if ($facility->id === (int)$value) {
                            $user->facility_id = $facility->id;
                        }
                    }
                }
            }
        }
        
        return $next($request);
    }
}
