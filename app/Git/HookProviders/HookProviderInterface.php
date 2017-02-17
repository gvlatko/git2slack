<?php

namespace App\Git\HookProviders;

interface HookProviderInterface
{
    /**
     * Name of this provider
     * @return string
     */
    public function name();

    /**
     * Identify that the hook comes from proper source
     * @return bool
     */
    public function identify();

    /**
     * Checks verify the hook is a valid one
     * @return bool
     */
    public function verify();

    /**
     * Returns the event that occurred
     * @return array|string
     */
    public function event();

    /**
     * Returns the payload of the event
     * @return array
     */
    public function payload();
}