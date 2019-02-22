<?php

namespace Thinktomorrow\Chief\Authorization;

use Illuminate\Support\Collection;

class AuthorizationDefaults
{
    /**
     * links the role to their default permissions, if the specific permission is defined only that permission is added
     * if the general type is defined (role, user) then the 4 basic permissions (create, view, update, delete) are
     * assumed to exist in the permissions function and will all be added.
     *
     * @return Collection
     */
    public static function roles(): Collection
    {
        return collect([

            // full access, even to application logic stuff
            'developer' => ['role', 'permission', 'user', 'page', 'module', 'disable-user', 'squanto', 'view-audit', 'view-setting', 'update-setting'],

            // Manages everything, including users
            'admin' => ['user', 'page', 'module', 'disable-user', 'view-squanto', 'update-squanto', 'view-audit', 'view-setting', 'update-setting'],

            // Writes and edits content
            'author' => ['page', 'module', 'view-squanto', 'update-squanto'],
        ]);
    }

    public static function permissions(): Collection
    {
        return collect([
            'view-permission',
            'create-permission',
            'update-permission',
            'delete-permission',

            'view-role',
            'create-role',
            'update-role',
            'delete-role',

            'view-user',
            'create-user',
            'update-user',
            'delete-user',
            'disable-user',

            'view-page',
            'create-page',
            'update-page',
            'delete-page',

            'view-squanto',
            'create-squanto',
            'update-squanto',
            'delete-squanto',

            'view-audit',

            'view-setting',
            'update-setting'
        ]);
    }
}
