<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ContactController;


// Admin Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/signin', [AuthController::class, 'login'])->name('admin.signin.post');


// Static routes pehle (exact matches)
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::get('/blogs', [PagesController::class, 'blog'])->name('blog');
Route::get('/blog/load-more', [PagesController::class, 'loadMore'])->name('blog.load-more');

Route::get('/services', [PagesController::class, 'services'])->name('services');
Route::get('/projects', [PagesController::class, 'projects'])->name('projects');
Route::get('/faq', [PagesController::class, 'faq'])->name('faq');
Route::get('/products', [PagesController::class, 'products'])->name('products');
Route::get('/sitemap', [PagesController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap.xml', [PagesController::class, 'sitemapxml'])->name('sitemap.xml');

// Specific parameterized routes
Route::get('/service/{slug}', [PagesController::class, 'servicedetail'])->name('service.details');
Route::get('/product/{slug}', [PagesController::class, 'productdetail'])->name('product.details');
Route::get('/project/{slug}', [PagesController::class, 'projectdetail'])->name('project.details');



// Contact form routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/test-email', [ContactController::class, 'testEmail']);
// Admin routes (protect these with auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
    Route::patch('/admin/contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('admin.contacts.status');
    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    
    // Bulk actions
    Route::post('/admin/contacts/bulk-status', [ContactController::class, 'bulkUpdateStatus'])->name('admin.contacts.bulk-status');
    Route::post('/admin/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('admin.contacts.bulk-delete');
});


// Blog detail route SABSE LAST mein
Route::get('/{slug}', [PagesController::class, 'blogdetail'])->name('blog.details');

