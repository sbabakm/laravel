<?php

if(! function_exists('isActive')) {
    function isActive($key , $activeClassName = 'active') {
        if(is_array($key)) {
            return in_array( Route::currentRouteName() , $key) ? $activeClassName : '';
        }
        return Route::currentRouteName() == $key ? 'active' : '';
    }
}

//khodam
//if(! function_exists('isUrl')) {
//    function isUrl($param , $activeClassName = 'active') {
//           return request('search') == $param ? $activeClassName : '';
//    }
//}

//ostad
if(! function_exists('isUrl') ) {

    function isUrl($url , $activeClassName = 'active') {
        return request()->fullUrlIs($url) ? $activeClassName : '';
    }

}
