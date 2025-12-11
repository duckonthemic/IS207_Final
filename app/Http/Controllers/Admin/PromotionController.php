<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PromotionController extends Controller
{
    /**
     * Display list of promotions
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Promotion::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($status) {
            switch ($status) {
                case 'active':
                    $query->valid();
                    break;
                case 'expired':
                    $query->where('expires_at', '<', now());
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }

        $promotions = $query->latest()->paginate(20);

        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show create promotion form
     */
    public function create(): View
    {
        return view('admin.promotions.create');
    }

    /**
     * Store new promotion
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        // Normalize code to uppercase
        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['usage_per_user'] = $validated['usage_per_user'] ?? 1;

        $promotion = Promotion::create($validated);

        AuditService::logCreate($promotion);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Mã giảm giá đã được tạo thành công');
    }

    /**
     * Show edit promotion form
     */
    public function edit(Promotion $promotion): View
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Update promotion
     */
    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['usage_per_user'] = $validated['usage_per_user'] ?? 1;

        $oldValues = $promotion->toArray();
        $promotion->update($validated);

        AuditService::logUpdate($promotion, $oldValues);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Mã giảm giá đã được cập nhật');
    }

    /**
     * Delete promotion
     */
    public function destroy(Promotion $promotion): RedirectResponse
    {
        // Check if promotion has been used
        if ($promotion->usage_count > 0) {
            return back()->with('error', 'Không thể xóa mã giảm giá đã được sử dụng. Bạn có thể vô hiệu hóa thay thế.');
        }

        AuditService::logDelete($promotion);
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Mã giảm giá đã được xóa');
    }

    /**
     * Toggle promotion status
     */
    public function toggleStatus(Promotion $promotion): RedirectResponse
    {
        $oldValues = $promotion->toArray();
        $promotion->update(['is_active' => !$promotion->is_active]);

        AuditService::logUpdate($promotion, $oldValues);

        $status = $promotion->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return back()->with('success', "Mã giảm giá đã được {$status}");
    }
}
