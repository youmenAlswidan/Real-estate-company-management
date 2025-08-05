<?php

namespace App\Traits\Admin;

/**
 * Trait ResponseTrait
 *
 * Provides standardized methods for handling success and error redirect responses with flash messages.
 */
trait ResponseTrait
{   
      /**
     * Redirect with a success message.
     *
     * Redirects the user to a named route with a success flash message.
     *
     * @param string $message The success message to display.
     * @param string $route The named route to redirect to.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function successResponse(string $message, string $route)
    {
        return redirect()->route($route)->with('success', $message);
    }

       /**
     * Redirect with an error message.
     *
     * Redirects the user to a named route with an error flash message.
     *
     * @param string $message The error message to display.
     * @param string $route The named route to redirect to.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function errorResponse(string $message, string $route)
    {
        return redirect()->route($route)->with('error', $message);
    }
}
