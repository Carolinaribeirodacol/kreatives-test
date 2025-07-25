<?php

use App\Http\Middleware\OnlyAdmin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => OnlyAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e) {
            return new JsonResponse([
                'message' => 'Não encontrado.',
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $e) {
            return new JsonResponse([
                'message' => 'Não autenticado.',
            ], 401);
        });

        $exceptions->render(function (AuthorizationException $e) {
            return new JsonResponse([
                'message' => 'Acesso negado.',
            ], 403);
        });

        $exceptions->render(function (ValidationException $e) {
            return new JsonResponse([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        });
    })->create();
