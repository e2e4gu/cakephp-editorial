<?php
namespace Editorial\Core\Core;

trait NamespaceTrait {

    function vendorSplit($name, $dashAppend = false, $vendor = null)
    {
        if (strpos($name, '/') !== false) {
            $parts = explode('/', $name, 2);
            if ($dashAppend) {
                $parts[0] .= '/';
            }
            return $parts;
        }
        return array($vendor, $name);
    }

}
