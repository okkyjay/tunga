<?php


namespace App\Classes;


class ProcessRegisterHookHelper
{
    public function processRegisteredHooks()
    {
        $this->register_hook("filter.data", function($result, $item) {
            if (is_array($item)){

            }
            return $result;
        });
    }
}
