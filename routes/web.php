<?php

use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminOperatingHourController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/reservasi', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservasi/terima-kasih', [ReservationController::class, 'thanks'])->name('reservations.thanks');

Route::get('/produk', [ProductController::class, 'index'])->name('products.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [CommentController::class, 'store'])->name('blog.comment.store');

Route::get('/sitemap.xml', function () {
    $urls = [
        route('home'),
        route('reservations.create'),
        route('products.index'),
        route('blog.index'),
    ];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $u) {
        $xml .= '<url><loc>'.$u.'</loc></url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('services', AdminServiceController::class);
    Route::resource('products', AdminProductController::class);
    Route::get('products-export', [AdminProductController::class, 'exportCsv'])->name('products.export');
    Route::get('products-export-pdf', [AdminProductController::class, 'exportPdf'])->name('products.export.pdf');
    Route::get('products-export-excel', [AdminProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::resource('blog', AdminBlogController::class);
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::resource('gallery', AdminGalleryController::class);
    Route::resource('hours', AdminOperatingHourController::class);
    Route::resource('reservations', AdminReservationController::class)->except(['create', 'store', 'show']);
    Route::get('reservations-export', [AdminReservationController::class, 'exportCsv'])->name('reservations.export');
    Route::get('reservations-export-pdf', [AdminReservationController::class, 'exportPdf'])->name('reservations.export.pdf');
    Route::get('reservations-export-excel', [AdminReservationController::class, 'exportExcel'])->name('reservations.export.excel');
});
