<?php

namespace App\Http\Middleware;

use App\Services\ModuleRegistry;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleEnabled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $moduleKey): Response
    {
        $user = $request->user();

        // Super admins have unrestricted access
        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        $orgId = $user?->organization_id;
        $branchId = $user?->branch_id;

        if (! ModuleRegistry::isEnabled($moduleKey, $orgId, $branchId)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Module Disabled',
                    'message' => "The module '{$moduleKey}' is currently disabled for your organization/branch.",
                ], 403);
            }

            abort(403, "The requested healthcare module [{$moduleKey}] is currently inactive. Contact your organization administrator.");
        }

        return $next($request);
    }
}
