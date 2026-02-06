<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\SkuGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        ]);

        // TODO: Get actual author_id from authenticated user
        $authorId = 1;

        // Create product
        $product = Product::create([
            'author_id' => $authorId,
            'primary_category_id' => $validated['primary_category_id'],
            'difficulty_level_id' => $validated['difficulty_level_id'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
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
        $product->delete();

        return redirect()
            ->route('author.dashboard')
            ->with('success', 'Мастер-класс успешно удален!');
    }
}
