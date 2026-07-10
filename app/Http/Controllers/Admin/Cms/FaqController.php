<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('question', 'like', '%' . $request->search . '%')
                  ->orWhere('answer', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $faqs = $query->ordered()->paginate(15)->withQueryString();

        $stats = [
            'total' => Faq::count(),
            'visible' => Faq::where('is_visible', true)->count(),
            'hidden' => Faq::where('is_visible', false)->count(),
        ];

        $editing = $request->filled('edit') ? Faq::find($request->get('edit')) : null;

        return view('admin.cms.faqs.index', compact('faqs', 'stats', 'editing'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $data['sort_order'] ?? (Faq::max('sort_order') ?? 0) + 1;

        Faq::create($data);

        return redirect()->route('admin.cms.faqs.index')->with('success', 'FAQ added successfully!');
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $this->validated($request);
        $data['is_visible'] = $request->boolean('is_visible');

        $faq->update($data);

        return redirect()->route('admin.cms.faqs.index')->with('success', 'FAQ updated successfully!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.cms.faqs.index')->with('success', 'FAQ deleted successfully!');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'category' => 'required|in:' . implode(',', Faq::CATEGORIES),
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
