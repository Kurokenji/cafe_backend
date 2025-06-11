<?php

use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/cloudinary-test', function () {
//     $filePath = public_path('images/cf_den.jpg');

//     if (!file_exists($filePath)) {
//         return '❌ File không tồn tại: ' . $filePath;
//     }

//     try {
//         $uploaded = Cloudinary::upload($filePath);

//         if (method_exists($uploaded, 'getSecurePath')) {
//             return '✅ Upload thành công: <br>' . $uploaded->getSecurePath();
//         } else {
//             dd('⚠️ Không có phương thức getSecurePath(). Kết quả trả về:', $uploaded);
//         }

//     } catch (\Exception $e) {
//         return '❌ Lỗi khi upload: ' . $e->getMessage();
//     }
// });

