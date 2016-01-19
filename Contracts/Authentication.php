<?php

namespace Modules\Core\Contracts;

interface Authentication
{
    /**
     * Authenticate a user.
     *
     * @param array $credentials
     * @param bool  $remember    Remember the user
     *
     * @return mixed
     */
    public function login(array $credentials, $remember = false);

    /**
     * Register a new user.
     *
     * @param array $user
     *
     * @return bool
     */
    public function register(array $user);

    /**
     * Activate the given used id.
     *
     * @param int    $userId
     * @param string $code
     *
     * @return mixed
     */
    public function activate($userId, $code);

    /**
     * Log the user out of the application.
     *
     * @return mixed
     */
    public function logout();

    /**
     * Completes the reset password process.
     *
     * @param $user
     * @param string $code
     * @param string $password
     *
     * @return bool
     */
    public function completeResetPassword($user, $code, $password);

    /**
     * Determines if the current user has access to given permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function hasAccess($permission);

    /**
     * Determines if the current user is in the given Role.
     *
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role);

    /**
     * Determines if the current user has a given Permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function can($permission);

    /**
     * Check if the user is logged in.
     *
     * @return mixed
     */
    public function check();

    /**
     * Get the currently loggedin user.
     *
     * @return mixed
     */
    public function user();

    /**
     * Handle an authentication attempt.
     *
     * @param $credentials
     * @return mixed
     */
    public function attempt($credentials);

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int
     */
    public function id();
}
