<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\SkuGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MasterclassController extends Controller
{
    /**
     * Show list of masterclasses.
     */
    public function index()
    {
        // TODO: Получить реальный author_id из аутентифицированного пользователя
        $authorId = 1;

        // Get products for this author
        $products = Product::where('author_id', $authorId)
            ->with(['activePrice', 'primaryCategory'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('author.masterclass-list', compact('products'));
    }

    /**
     * Show the form for creating a new masterclass.
     */
    public function create()
    {
        $product = null;
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $difficultyLevels = \App\Models\DifficultyLevel::orderBy('sort_order')->get();

        return view('author.masterclasses.edit', compact('product', 'categories', 'difficultyLevels'));
    }

    /**
     * Store a newly created masterclass.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'materials_text' => 'nullable|string',
            'primary_category_id' => 'required|exists:categories,id',
            'difficulty_level_id' => 'nullable|exists:difficulty_levels,id',
            'additional_categories' => 'nullable|array',
            'additional_categories.*' => 'exists:categories,id',
            'format' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // TODO: Get actual author_id from authenticated user
        $authorId = 1;

        // Generate SKU
        $skuGenerator = new SkuGeneratorService();
        $sku = $skuGenerator->generate($validated['primary_category_id']);

        // Create product
        $product = Product::create([
            'author_id' => $authorId,
            'primary_category_id' => $validated['primary_category_id'],
            'difficulty_level_id' => $validated['difficulty_level_id'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'sku' => $sku,
            'short_description' => $validated['short_description'] ?? '',
            'description' => $validated['description'] ?? '',
            'format' => $validated['format'] ?? null,
            'materials' => isset($validated['materials_text']) ? ['text' => $validated['materials_text']] : null,
            'what_you_learn' => isset($validated['skills']) ? $validated['skills'] : null,
            'status' => 'draft',
        ]);

        // Add additional categories
        if (!empty($validated['additional_categories'])) {
            $product->categories()->attach($validated['additional_categories']);
        }

        // Create price
        $product->prices()->create([
            'price' => $validated['price'],
            'old_price' => $validated['old_price'] ?? null,
            'is_active' => true,
        ]);

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImagePath = $mainImage->store('products/images', 'public');
            
            $product->images()->create([
                'image_path' => $mainImagePath,
                'is_main' => true,
                'sort_order' => 0,
            ]);
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $imagePath = $image->store('products/images', 'public');
                
                $product->images()->create([
                    'image_path' => $imagePath,
                    'is_main' => false,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('author.masterclasses.edit', $product->id)
            ->with('success', 'Мастер-класс успешно создан!');
    }

    /**
     * Show the form for editing the specified masterclass.
     */
    public function edit($id)
    {
        $product = Product::with(['activePrice', 'mainImage', 'images', 'categories', 'difficultyLevel'])
            ->findOrFail($id);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $difficultyLevels = \App\Models\DifficultyLevel::orderBy('sort_order')->get();

        return view('author.masterclasses.edit', compact('product', 'categories', 'difficultyLevels'));
    }

    /**
     * Update the specified masterclass.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'materials_text' => 'nullable|string',
            'primary_category_id' => 'required|exists:categories,id',
            'difficulty_level_id' => 'nullable|exists:difficulty_levels,id',
            'additional_categories' => 'nullable|array',
            'additional_categories.*' => 'exists:categories,id',
            'format' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'gallery_images' => 'nullable|array|max:8',
            'gallery_images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
            'images_order' => 'nullable|json',
        ]);

        // Если категория изменилась, перегенерируем SKU
        $updateData = [
            'primary_category_id' => $validated['primary_category_id'],
            'difficulty_level_id' => $validated['difficulty_level_id'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'short_description' => $validated['short_description'] ?? '',
            'description' => $validated['description'] ?? '',
            'format' => $validated['format'] ?? null,
            'materials' => isset($validated['materials_text']) ? ['text' => $validated['materials_text']] : null,
            'what_you_learn' => isset($validated['skills']) ? $validated['skills'] : null,
        ];

        if ($product->primary_category_id != $validated['primary_category_id']) {
            $skuGenerator = new SkuGeneratorService();
            $updateData['sku'] = $skuGenerator->generate($validated['primary_category_id']);
        }

        $product->update($updateData);

        // Sync additional categories
        if (isset($validated['additional_categories'])) {
            $product->categories()->sync($validated['additional_categories']);
        } else {
            $product->categories()->detach();
        }

        // Update or create active price
        $activePrice = $product->activePrice;
        if ($activePrice) {
            $activePrice->update([
                'price' => $validated['price'],
                'old_price' => $validated['old_price'] ?? null,
            ]);
        } else {
            $product->prices()->create([
                'price' => $validated['price'],
                'old_price' => $validated['old_price'] ?? null,
                'is_active' => true,
            ]);
        }

        // Handle image deletions
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = $product->images()->whereIn('id', $validated['delete_images'])->get();
            foreach ($imagesToDelete as $image) {
                // Delete file from storage
                if (\Storage::disk('public')->exists($image->image_path)) {
                    \Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        }

        // Handle new main image upload
        if ($request->hasFile('main_image')) {
            // Delete old main image if exists
            $oldMainImage = $product->mainImage;
            if ($oldMainImage) {
                if (\Storage::disk('public')->exists($oldMainImage->image_path)) {
                    \Storage::disk('public')->delete($oldMainImage->image_path);
                }
                $oldMainImage->delete();
            }
            
            $mainImage = $request->file('main_image');
            $mainImagePath = $mainImage->store('products/images', 'public');
            
            $product->images()->create([
                'image_path' => $mainImagePath,
                'is_main' => true,
                'sort_order' => 0,
            ]);
        }

        // Handle new gallery images upload
        if ($request->hasFile('gallery_images')) {
            $currentMaxOrder = $product->images()->where('is_main', false)->max('sort_order') ?? 0;
            
            foreach ($request->file('gallery_images') as $index => $image) {
                $imagePath = $image->store('products/images', 'public');
                
                $product->images()->create([
                    'image_path' => $imagePath,
                    'is_main' => false,
                    'sort_order' => $currentMaxOrder + $index + 1,
                ]);
            }
        }

        // Handle images reordering
        if ($request->has('images_order') && !empty($request->images_order)) {
            $imagesOrder = json_decode($request->images_order, true);
            
            if (is_array($imagesOrder)) {
                foreach ($imagesOrder as $index => $imageId) {
                    $product->images()->where('id', $imageId)->update([
                        'sort_order' => $index + 1,
                        'is_main' => $index === 0,
                    ]);
                }
            }
        }

        return redirect()
            ->route('author.masterclasses.edit', $product->id)
            ->with('success', 'Мастер-класс успешно обновлен!');
    }

    /**
     * Publish the masterclass.
     */
    public function publish($id)
    {
        $product = Product::findOrFail($id);
        
        $product->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()
            ->route('author.masterclasses.edit', $product->id)
            ->with('success', 'Мастер-класс успешно опубликован!');
    }

    /**
     * Delete the masterclass.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete related data before deleting the product
        // Images (if any)
        $product->images()->delete();
        
        // Prices
        $product->prices()->delete();
        
        // Category relations (many-to-many)
        $product->categories()->detach();
        
        // Delete the product (soft delete)
        $product->delete();

        return redirect()
            ->route('author.masterclasses.index')
            ->with('success', 'Мастер-класс успешно удален!');
    }
}
