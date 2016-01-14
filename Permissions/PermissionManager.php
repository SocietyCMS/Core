<?php

namespace Modules\Core\Permissions;

use Illuminate\Contracts\Container\Container;
use Modules\User\Entities\Entrust\EloquentPermission;

/**
 * Class PermissionManager
 * @package Modules\Core\Permissions
 */
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
        $this->permissions = new EloquentPermission;
    }

    /**
     * Get the permissions from all the enabled modules.
     *
     * @return array
     */
    public function all()
    {
        return $this->permissions->orderBy('module')->get()->groupBy('module');
    }

    /**
     * Get the permissions from all the enabled modules.
     *
     * @return array
     */
    public function allModulePermissions()
    {
        return $this->permissions->orderBy('module')->get()->groupBy('module');
    }


    /**
     * @param $module
     * @return bool
     */
    public function registerDefault($module)
    {
        $name = studly_case($module->getName());
        $class = 'Modules\\' . $name . '\\Installer\\RegisterDefaultPermissions';

        if (!class_exists($class)) {
            return false;
        }

        $registerDefaultPermissions = $this->container->make($class);

        if (!property_exists($registerDefaultPermissions, 'defaultPermissions')) {
            return false;
        }

        foreach ($registerDefaultPermissions->defaultPermissions as $permissionName => $permissionOption) {
            if (!$this->permissions->where('name', '=', "{$module->getLowerName()}::$permissionName")->first()) {
                $this->permissions->create([
                    'name'         => "{$module->getLowerName()}::$permissionName",
                    'display_name' => $permissionOption['display_name'],
                    'description'  => $permissionOption['description'],
                    'module'       => $module->getLowerName(),
                ]);
            }
        }
        return true;
    }

    /**
     * @param $module
     */
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
