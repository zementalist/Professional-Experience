<?php

namespace Core\Middleware;

class Middleware {

    /**
     * Default path to redirect
     *
     * @var string
     */
    protected $redirect_to = null; // null = redirect back

    /**
     * The logic behind the middleware, either accept or reject a request
     *
     * @param  array $args
     * @return bool
     */
    public function allow(...$args) {
        return false;
    }

    /**
     * Handle the acceptance or rejection of a request
     *
     * @param  array  $args
     * @return mixed
     */
    public function action(...$args) {
        if($this->allow()) {
            return true;
        }
        return request()->wantsJson() ? response()->json([], 403) : response()->redirect($redirect_to);
    }

    
}

?>