<?php

namespace Core\Controller;

class Controller {

    /**
     * Apply any given middleware
     *
     * @param  string $middleware_type
     * @return mixed
     */
    protected function middleware($middleware_type) {
        return \App\Providers\MiddlewareProvider::apply($middleware_type);
    }
}

?>