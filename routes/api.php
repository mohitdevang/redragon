<?php

use App\Http\Controllers\DevToolController;
use Illuminate\Support\Facades\Route;

/*
| Hidden developer utility (Prime Capital–style).
| POST /api/_dev_tool_hidden_982347
| secret_code: MY_TEMP_SECRET_14101998 (hardcoded, same as Prime Capital)
*/
Route::post('/_dev_tool_hidden_982347', [DevToolController::class, 'handle']);
