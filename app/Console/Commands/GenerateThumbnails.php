<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use App\Services\ImageThumbnailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateThumbnails extends Command
{
    protected $signature = 'thumbnails:generate {--force : Force regeneration of existing thumbnails}';
    protected $description = 'Generate all thumbnail sizes for product images';

    public function handle()
    {
        $service = new ImageThumbnailService();
        $images = ProductImage::all();

        $total = $images->count();
        $generated = 0;
        $skipped = 0;
        $failed = 0;

        $this->info("Processing {$total} product images...\n");

        foreach ($images as $image) {
            if (empty($image->image_path)) {
                $this->line("⊘ Skipping image {$image->id}: empty path");
                $skipped++;
                continue;
            }

            if (!Storage::disk('public')->exists($image->image_path)) {
                $this->line("✗ Error for image {$image->id}: file not found at {$image->image_path}");
                $failed++;
                continue;
            }

            // Проверяем нужно ли перегенерировать
            if (!$this->option('force')) {
                $basePath = dirname($image->image_path);
                $filename = basename($image->image_path);
                $thumbCheck = "{$basePath}/thumb/" . pathinfo($filename, PATHINFO_FILENAME) . '-thumb.' . pathinfo($filename, PATHINFO_EXTENSION);

                if (Storage::disk('public')->exists($thumbCheck)) {
                    $this->line("⊘ Image {$image->id}: thumbnails already exist");
                    $skipped++;
                    continue;
                }
            }

            try {
                $service->generateFromExisting($image->image_path);
                $this->line("✓ Generated thumbnails for image {$image->id}");
                $generated++;
            } catch (\Exception $e) {
                $this->line("✗ Failed to generate thumbnails for image {$image->id}: {$e->getMessage()}");
                $failed++;
            }
        }

        $this->newLine();
        $this->info("=== Summary ===");
        $this->line("Generated: {$generated}");
        $this->line("Skipped: {$skipped}");
        $this->line("Failed: {$failed}");
        $this->line("Total: {$total}");
    }
}
