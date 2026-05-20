<?php 

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    protected $levels = [];
    protected $dontReport = [];
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
       $this->renderable(function (MethodNotAllowedHttpException $e, $request) {

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Invalid HTTP method used'
            ], 405);
        }

        return redirect()->back()->with('error', 'Invalid HTTP method used');
    });
    }
}