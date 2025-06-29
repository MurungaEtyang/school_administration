<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Modules\TwoFactorAuth\Entities\TwoFactorSetting;
use Modules\Fees\Http\Controllers\MpesaCallbackController;

// Clear route cache - accessible at /clear-route-cache
Route::get('/clear-route-cache', function() {
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    
    return response()->json([
        'success' => true,
        'message' => 'Route cache cleared!',
        'data' => [
            'time' => now()->toDateTimeString()
        ]
    ]);
});

// Simple test route - should be accessible at /test-route
Route::get('/test-route', function () {
    return response()->json([
        'success' => true,
        'message' => 'Test route is working!',
        'data' => [
            'current_path' => request()->path(),
            'full_url' => request()->fullUrl(),
            'time' => now()->toDateTimeString()
        ]
    ]);
});

// Debug route to list all routes
Route::get('/debug/routes', function () {
    $routes = [];
    
    foreach (\Route::getRoutes() as $route) {
        $uri = $route->uri();
        $name = $route->getName() ?? '';
        
        // Only include routes that have 'homework' or 'assignment' in them
        if (str_contains($uri, 'homework') || 
            str_contains($uri, 'assignment') ||
            str_contains($name, 'homework') || 
            str_contains($name, 'assignment')) {
            
            $routes[] = [
                'uri' => $uri,
                'methods' => $route->methods(),
                'name' => $name,
                'action' => $route->getActionName(),
            ];
        }
    }
    
    return response()->json([
        'success' => true,
        'routes' => $routes
    ]);
});

// Test homework route
Route::get('/test-homework', function () {
    return response()->json([
        'success' => true,
        'routes' => [
            'homework_list_exists' => \Route::has('homework-list'),
            'assignment_list_exists' => \Route::has('assignment-list'),
            'current_path' => request()->path()
        ]
    ]);
});

// Debug routes
Route::get('/debug/route-info', 'DebugController@testRoute');
Route::get('/debug/test-homework', 'DebugController@testHomeworkRedirect');

// Test route to check if we can access homework/assignment routes
Route::get('/test-homework-route', function () {
    return response()->json([
        'success' => true,
        'message' => 'Homework test route is working!',
        'data' => [
            'route' => 'homework-list',
            'redirects_to' => route('assignment-list', [], false),
            'direct_url' => url('homework-list'),
            'route_exists' => \Route::has('homework-list')
        ]
    ]);
});

// Bypass installation check
Route::get('/bypass-installation', function () {
    // Create installation files if they don't exist
    $files = [
        'installed' => '1',
        '.app_installed' => '1',
        '.version' => '1.0',
    ];

    foreach ($files as $file => $content) {
        $path = storage_path('app/' . $file);
        if (!File::exists($path)) {
            File::put($path, $content);
        }
    }

    return response('Installation bypassed successfully');
});

// Clear application cache
Route::get('/clear-cache', function () {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    return 'Application cache cleared.';
});

// M-Pesa API Routes
Route::prefix('mpesa')->group(function () {
    // Callback URL for M-Pesa STK push
    Route::post('/callback', [MpesaCallbackController::class, 'handleStkCallback'])
        ->name('mpesa.callback');
        
    // Save transaction after successful STK push
    Route::post('/save-transaction', [MpesaCallbackController::class, 'saveTransaction'])
        ->name('mpesa.save-transaction');
        
    // Check payment status (allow both web and API access)
    Route::match(['get', 'post'], '/payment/status', [MpesaCallbackController::class, 'checkPaymentStatus'])
        ->name('mpesa.payment.status')
        ->withoutMiddleware(['web', 'csrf']);
});

Route::get('resdg', function () {
    $gs = generalSetting();
        $gs->two_factor = 0 ;
        $gs->save();

        session()->forget('generalSetting');
        session()->put('generalSetting', $gs);

        $setting = TwoFactorSetting::where('school_id', Auth::user()->school_id)->first();
        $setting->via_sms =  0; 
        $setting->via_email = 0; 
        $setting->expired_time =   0; 
        $setting->for_student =  0; 
        $setting->for_parent =  0; 
        $setting->for_teacher =  0; 
        $setting->for_staff = 0;  
        $setting->for_admin = 0;  
        $setting->update();
});

if (config('app.app_sync')) {
    Route::get('/', 'LandingController@index')->name('/');
}

// Debug routes - TODO: Remove in production
require __DIR__.'/web_debug.php';

if (moduleStatusCheck('Saas')) {
    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}.' . config('app.short_url')], function ($routes) {
        require('tenant.php');
    });

    Route::group(['middleware' => ['subdomain'], 'domain' => '{subdomain}'], function ($routes) {
        require('tenant.php');
    });
}

Route::group(['middleware' => ['subdomain']], function ($routes) {
    require('tenant.php');
});

Route::get('migrate', function () {
    if(Auth::check() && Auth::id() == 1){
        \Artisan::call('migrate', ['--force' => true]);
        \Brian2694\Toastr\Facades\Toastr::success('Migration run successfully');
        return redirect()->to(url('/admin-dashboard'));
    }
    abort(404);
});


Route::post('editor/upload-file', 'UploadFileController@upload_image');
