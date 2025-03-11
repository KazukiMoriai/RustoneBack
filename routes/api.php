use Illuminate\Support\Facades\Route;

Route::post('/upload-image', [App\Http\Controllers\ImageController::class, 'store']); 