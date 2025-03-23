<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api([
                    \App\Http\Middleware\EnsureJsonResponseForApi::class,
                ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Throwable $e, Request $request) {
            Log::error($e->getMessage());
            if ($request->is('api/*')) {
                // Capturar errores de base de datos
                if ($e instanceof QueryException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ocurrió un error en la base de datos.',
                        'error' => $e->getMessage(), // Solo para depuración en desarrollo 
                    ], 500);
                }
    
                // Capturar errores de modelo no encontrado
                if ($e instanceof ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recurso no encontrado.',
                    ], 404);
                }
    
                // Capturar errores de ruta no encontrada
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ruta no encontrada.',
                    ], 404);
                }

                if($e instanceof ValidationException){
                    return response()->json([
                        'success' => false,
                        'message' => 'Error de validación.',
                        'errors' => $e->errors(),
                    ], 422);
                }
    
                // Capturar otros errores desconocidos
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error inesperado.',
                ], 500);
            }
    
            return null;
        });
    })
    ->create();
