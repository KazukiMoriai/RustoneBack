use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PhotoController;

Route::post('/upload-image', [App\Http\Controllers\ImageController::class, 'store']);
Route::post('/upload', [PhotoController::class, 'upload']); 