<?php

namespace App\Http\Middleware;
use App\Http\Models\module;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Closure;
use Menu;

class GenerateMenu
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
        if(isset(Auth::user()->id)) {
            $employeeID = Auth::user()->id;

            $permissionsMain = Permission::selectRaw('module.id')->join('module_permission', 'module_permission.permission_id', '=', 'permissions.id')
            ->join('module', 'module.id', '=', 'module_permission.module_id')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_id', $employeeID)
            ->where('module.parent_id', 0)
            ->groupBy('module.id')->get()->toArray();

        //  dd($permissions);
    //      $modules = module::select('id', 'platform', 'module_name', 'url', 'icon')->where('platform', 'web')->where('parent_id', 0)->get();
            $modules = module::select('id', 'platform', 'module_name', 'url', 'icon')->where('platform', 'web')->whereIn('id', $permissionsMain)->get();
            
    //        $modules = module::with(['submenu' => function($query) use ($permissions) {
    //            $query->whereIn('id', $permissions)->where('isdelete', 0)->where('platform', 'web')->get();
    //        }])->where('platform', 'web')->where('parent_id', 0)->whereIn('id', $permissions)->where('status', 'on')->where('isdelete', 0)->orderBy('id')->get()->toArray();
        
            $fullMenu = Menu::make('MyNavBar', function ($menu) {
            });
            $permissionsSub = Permission::selectRaw('module.id')->join('module_permission', 'module_permission.permission_id', '=', 'permissions.id')
            ->join('module', 'module.id', '=', 'module_permission.module_id')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_id', $employeeID)
            ->where('module.parent_id', '!=', 0)
            ->groupBy('module.id')->get()->toArray();

            foreach($modules as $module) {
                $subMenu = $fullMenu->add($module->module_name, ['url' => $module->url, 'id' => "$module->id", 'icon' => $module->icon]);
                $subModules = module::select('id', 'platform', 'module_name', 'url')->where('platform', 'web')
                ->where('parent_id', $module->id)
                ->whereIn('id', $permissionsSub)
                ->where('status', 'on')
                ->get();
                foreach($subModules as $subModule) {
                    $subMenu->add($subModule->module_name, $subModule->url);
                }
            
            }
        }
        return $next($request);
    }
}
