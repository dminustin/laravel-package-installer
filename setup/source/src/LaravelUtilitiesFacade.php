<?php

declare(strict_types=1);

namespace AMFNamespace\AMFClassNamePrefix;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AMFNamespace\AMFClassNamePrefix\Skeleton\AMFClassNamePrefixSkeletonClass
 */
class AMFClassNamePrefixFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AMFName';
    }
}
