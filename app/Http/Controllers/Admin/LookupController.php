<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LookupController extends Controller
{
    private array $models = [
        'climate-systems' => [
            'model' => \App\Models\ClimateSystem::class,
            'label' => 'سیستم تهویه',
            'fields' => ['name', 'name_fa', 'slug'],
        ],
        'floor-materials' => [
            'model' => \App\Models\FloorMaterial::class,
            'label' => 'متریال کف',
            'fields' => ['name', 'name_fa', 'slug'],
        ],
        'building-materials' => [
            'model' => \App\Models\BuildingMaterial::class,
            'label' => 'متریال ساختمان',
            'fields' => ['name', 'name_fa', 'slug'],
        ],
        'documents' => [
            'model' => \App\Models\Document::class,
            'label' => 'مدارک',
            'fields' => ['name', 'name_fa', 'slug'],
        ],
        'features' => [
            'model' => \App\Models\Feature::class,
            'label' => 'امکانات',
            'fields' => ['name', 'name_fa', 'category'],
        ],
        'property-types' => [
            'model' => \App\Models\PropertyType::class,
            'label' => 'نوع ملک',
            'fields' => ['name', 'name_fa', 'slug', 'category'],
        ],
        'property-statuses' => [
            'model' => \App\Models\PropertyStatus::class,
            'label' => 'وضعیت ملک',
            'fields' => ['name', 'name_fa', 'slug'],
        ],
    ];

    private function getConfig(string $type): array
    {
        if (!isset($this->models[$type])) {
            abort(404);
        }
        return $this->models[$type];
    }

    public function index(string $type)
    {
        $config = $this->getConfig($type);
        $query = $config['model']::latest();

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search, $config) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_fa', 'like', "%{$search}%");
                if (in_array('slug', $config['fields'])) {
                    $q->orWhere('slug', 'like', "%{$search}%");
                }
                if (in_array('category', $config['fields'])) {
                    $q->orWhere('category', 'like', "%{$search}%");
                }
            });
        }

        $items = $query->paginate(15)->withQueryString();

        return view('admin.lookup.index', compact('items', 'type', 'config'));
    }

    public function create(string $type)
    {
        $config = $this->getConfig($type);
        return view('admin.lookup.create', compact('type', 'config'));
    }

    public function store(Request $request, string $type)
    {
        $config = $this->getConfig($type);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_fa' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:' . (new $config['model'])->getTable() . ',slug',
            'category' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $config['model']::create($validated);

        return redirect()->route('admin.lookup.index', $type)->with('success', "{$config['label']} با موفقیت ایجاد شد");
    }

    public function edit(string $type, int $id)
    {
        $config = $this->getConfig($type);
        $item = $config['model']::findOrFail($id);

        return view('admin.lookup.edit', compact('item', 'type', 'config'));
    }

    public function update(Request $request, string $type, int $id)
    {
        $config = $this->getConfig($type);
        $item = $config['model']::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_fa' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:' . $item->getTable() . ',slug,' . $item->id,
            'category' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $item->update($validated);

        return redirect()->route('admin.lookup.index', $type)->with('success', "{$config['label']} با موفقیت بروزرسانی شد");
    }

    public function destroy(string $type, int $id)
    {
        $config = $this->getConfig($type);
        $item = $config['model']::findOrFail($id);

        if ($type === 'property-types') {
            Property::where('type_id', $item->id)->update(['type_id' => null]);
        } elseif ($type === 'property-statuses') {
            Property::where('status_id', $item->id)->update(['status_id' => null]);
        }

        $item->delete();

        return redirect()->route('admin.lookup.index', $type)->with('success', "{$config['label']} با موفقیت حذف شد");
    }
}
