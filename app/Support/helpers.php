<?php

if ( !function_exists('user') )
{
    /**
     * @param null $driver
     *
     * @return mixed
     */
    function user($driver = null)
    {
        if( $driver )
        {
            return app('auth')->guard($driver)->user(); // user('api') 取到api用户的数据
        }

        return app('auth')->user();
    }
}
