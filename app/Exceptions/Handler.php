<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    private $sentryID;

    /**
     * Reduce noise by not reporting these exceptions which happen frequently by bots/spammers etc
     */
    protected $dontReport = [
        NotFoundHttpException::class,
        ModelNotFoundException::class,
        MethodNotAllowedHttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->sentryEnabled() && $this->shouldReport($e)) {
            $this->sentryID = app('sentry')->captureException($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (!empty($this->sentryID) && $this->sentryEnabled() && $this->shouldReport($e) && !$request->is('admin/*')) {
            return response()->make(view('errors.500', [
                'sentryID' => $this->sentryID,
            ]), 500);
        }

        return parent::render($request, $e);
    }

    /**
     * Enable sentry when both ENV variables are enabled and not development.
     * NOTE: If you modify this method, also modify the if statement in bootstrap/app.php
     *
     * @return bool
     */
    private function sentryEnabled()
    {
        return (env('SENTRY_DSN', false) && env('SENTRY_PUBLIC_DSN', false) && env('APP_ENV') != ENV_DEVELOPMENT);
    }
}
