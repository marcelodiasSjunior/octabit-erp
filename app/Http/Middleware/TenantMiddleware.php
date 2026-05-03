<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\TenantManager;
use App\Models\Company;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantManager = app(TenantManager::class);

        // 1. Detect by Host (Subdomain)
        $host = $request->getHost();
        $parts = explode('.', $host);
        
        if (count($parts) >= 3 && $parts[count($parts)-2] === 'octabit' && $parts[count($parts)-1] === 'tech') {
            $subdomain = $parts[0];
            
            // Check if it's not the main 'www' or empty
            if ($subdomain !== 'www' && $subdomain !== 'octabit') {
                $company = Company::where('subdomain', $subdomain)->first();
                if ($company) {
                    $tenantManager->setCompanyId($company->id);
                }
            }
        }

        // 2. Fallback to Authenticated User (if already logged in)
        if (!$tenantManager->hasTenant() && auth()->check()) {
            $user = auth()->user();
            if ($user->company_id) {
                $tenantManager->setCompanyId($user->company_id);
            }
        }

        return $next($request);
    }
}
