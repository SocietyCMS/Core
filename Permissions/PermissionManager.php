<?php

namespace Modules\Core\Permissions;

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

    /**
     * @param $checkedPermission
     *
     * @return bool
     */
    protected function getState($checkedPermission)
    {
        if ($checkedPermission == 'true') {
            return true;
        }

        if ($checkedPermission == 'false') {
            return;
        }

        return;
    }
}
