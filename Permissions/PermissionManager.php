<?php

namespace Modules\Core\Permissions;

use Illuminate\Contracts\Container\Container;
use Modules\User\Entities\Entrust\EloquentPermission;

/**
 * Class PermissionManager.
 */
class PermissionManager
{
    /**
     * @var Module
     */
    private $module;

    public function __construct()
    {
        $this->container = app(Container::class);
        $this->module = app('modules');
        $this->permissions = new EloquentPermission();
    }

    /**
     * Get all permissions from all the enabled modules.
     *
     * @return array
     */
    public function all()
    {
        return $this->permissions->orderBy('module')->get()->groupBy('module');
    }

    /**
     * Get only the managed permissions from the enabled modules.
     *
     * @return array
     */
    public function allManagedPermissions()
    {
        return $this->permissions->where('name', 'NOT LIKE', '%:unmanaged::%')->orderBy('module')->get()->groupBy('module');
    }

    /**
     * Get only the managed permissions from the enabled modules.
     *
     * @return array
     */
    public function getPermission($name)
    {
        return $this->permissions->where('name', $name)->first();
    }

    /**
     * @param $module
     *
     * @return bool
     */
    public function registerDefault($module)
    {
        $name = studly_case($module->getName());
        $class = 'Modules\\'.$name.'\\Installer\\RegisterDefaultPermissions';

        if (! class_exists($class)) {
            return false;
        }

        $registerDefaultPermissions = $this->container->make($class);

        if (! property_exists($registerDefaultPermissions, 'defaultPermissions')) {
            return false;
        }

        foreach ($registerDefaultPermissions->defaultPermissions as $permissionName => $permissionOption) {
            $this->registerPermission(
                "{$module->getLowerName()}::$permissionName",
                $permissionOption['display_name'],
                $permissionOption['description'],
                $module->getLowerName()
            );
        }

        return true;
    }

    public function registerPermission($name, $display_name = null, $description = null, $module = null)
    {
        if (! $this->permissions->where('name', '=', $name)->first()) {
            return $this->permissions->create([
                'name'         => $name,
                'display_name' => $display_name,
                'description'  => $description,
                'module'       => $module,
            ]);
        }
    }

    /**
     * @param $module
     */
    public function rollbackDefault($module)
    {
        $name = studly_case($module->getName());
        $class = 'Modules\\'.$name.'\\Installer\\RegisterDefaultPermissions';

        if (class_exists($class)) {
            $registerDefaultPermissions = $this->container->make($class);

            if (property_exists($registerDefaultPermissions, 'defaultPermissions')) {
                $permission = EloquentPermission::whereIn('name', array_keys($registerDefaultPermissions->defaultPermissions));
                $permission->delete();
            }
        }
    }
}
