<?php

namespace App\Providers;

use App\Kernel;

class MiddlewareProvider {
    public static function apply($middleware_type) {
        if(is_array($middleware_type)) {
            foreach ($middleware_type as $middleware) {
                if($response = self::verify($middleware))
                    return $response;
            }
        }
        else {
            if($response = self::verify($middleware_type)) {
                return $response;
            }
        }
        
    }

    public static function verify($middleware_type) {
        $middleware_class = (new Kernel())->middleware["$middleware_type"] ?? "";
        echo $middleware_class;
        try{
            $middleware = new $middleware_class;
        }
        catch(\Exception $e) {
            throw $e;
        }
        if(!$middleware->allow()) {
            $to = $middleware->redirect_to ?? session()->get("previous_url");
            return response()->redirect($to);
        }
    }
}

?>