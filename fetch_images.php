<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$books = Book::all();

foreach ($books as $book) {
    echo "Searching cover for: " . $book->title . "\n";
    $query = urlencode($book->title . ' ' . $book->author);
    $response = Http::timeout(30)->get("https://openlibrary.org/search.json?q={$query}&limit=1");
    if ($response->successful() && isset($response->json()['docs'][0]['cover_i'])) {
        $coverId = $response->json()['docs'][0]['cover_i'];
        $imageUrl = "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg";
        
        echo "Downloading: $imageUrl\n";
        $imageContent = file_get_contents($imageUrl);
        
        if ($imageContent) {
            $filename = 'books/' . Str::slug($book->title) . '-' . time() . '.jpg';
            Storage::disk('public')->put($filename, $imageContent);
            $book->cover = $filename;
            $book->save();
            echo "Saved as $filename\n";
        } else {
            echo "Failed to download image.\n";
        }
    } else {
        echo "No cover found for: " . $book->title . "\n";
    }
}

echo "Done.\n";
