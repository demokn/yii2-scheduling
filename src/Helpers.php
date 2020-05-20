<?php

namespace omnilight\scheduling;

/**
 * Determine whether the current environment is Windows based.
 *
 * @return bool
 */
function window_os()
{
    return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
}
