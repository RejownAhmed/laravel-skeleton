<?php

use App\Exceptions\GeneralException;

if (!function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches subdirectories as well.
     *
     * @param $folder
     * @throws GeneralException
     */
    function include_route_files($folder): void
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            Log::error($e);
            // throw new GeneralException($e->getMessage());
        }
    }
}
