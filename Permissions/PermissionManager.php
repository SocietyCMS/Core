<?php

namespace Modules\Core\Permissions;

use Illuminate\Contracts\Container\Container;
use Modules\User\Entities\Entrust\EloquentPermission;

class PermissionManager
{
    /**
     * @var Module
     */
    private $module;

    /**
     */
    public function __construct()
    {
        $this->container = app(Container::class);
        $this->module = app('modules');
    }

    /**
     * Return a correctly type casted permissions array.
     *
     * @param $permissions
     *
     * @return array
     */
    public function clean($permissions)
    {
        if (!$permissions) {
            return [];
        }
        $cleanedPermissions = [];

        $allPermission = $this->all();

        foreach ($permissions as $permissionGroupName => $checkedPermission) {
            foreach (array_get($allPermission, $permissionGroupName) as $permissionName) {
                $cleanedPermissions[$permissionName] = $this->getState($checkedPermission);
            }
        }

        return $cleanedPermissions;
    }

    /**
     * Get the permissions from all the enabled modules.
     *
     * @return array
     */
    public function all()
    {
        $permissions = [];
        foreach ($this->module->enabled() as $enabledModule) {
            $configuration = config(strtolower('society.'.$enabledModule->getName()).'.permissions');
            if ($configuration) {
                $permissions[$enabledModule->getName()] = $configuration;
            }
        }

        return $permissions;
    }



    public function registerDefault($module)
    {
            $name = studly_case($module->getName());
            $class = 'Modules\\' . $name . '\\Installer\\RegisterDefaultPermissions';

            if (class_exists($class)) {
                $registerDefaultPermissions = $this->container->make($class);

                if(property_exists($registerDefaultPermissions, 'defaultPermissions')) {
                    foreach($registerDefaultPermissions->defaultPermissions as $permissionName => $permissionOption)
                    {
                        $permission = new EloquentPermission;
                        $permission->name         = $permissionName;
                        $permission->display_name = $permissionOption['display_name'];
                        $permission->description  = $permissionOption['description'];
                        $permission->save();
                    }
                }

            }
    }

    public function rollbackDefault($module)
    {
        $name = studly_case($module->getName());
        $class = 'Modules\\' . $name . '\\Installer\\RegisterDefaultPermissions';

        if (class_exists($class)) {
            $registerDefaultPermissions = $this->container->make($class);

            if(property_exists($registerDefaultPermissions, 'defaultPermissions')) {


                $permission = EloquentPermission::whereIn('name', array_keys($registerDefaultPermissions->defaultPermissions));
                $permission->delete();
            }

        }
    }
}
