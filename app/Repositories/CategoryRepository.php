<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Http\Request;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return \App\Models\Category::class;
    }

    /**
     * Tampilkan daftar kategori menggunakan DataTable.
     */
    public function index($dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * Halaman form create kategori.
     */
    public function create(array $attributes = [])
    {
        return view('admin.category.create', $attributes);
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'type']);
            $data['created_by'] = Auth::id();

            $this->model->create($data);

            DB::commit();
            return redirect()
                ->route('admin.category.index')
                ->with('success', __('Category created successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit($id)
    {
        $category = $this->model->findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update data kategori.
     */
    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $category = $this->model->findOrFail($id);

            $data = $request->only(['name', 'type']);
            $data['created_by'] = Auth::id();

            $category->update($data);

            DB::commit();
            return redirect()
                ->route('admin.category.index')
                ->with('success', __('Category updated successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Hapus kategori berdasarkan ID.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = $this->model->findOrFail($id);
            $category->delete();

            DB::commit();
            return redirect()
                ->back()
                ->with('success', __('Category deleted successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Hapus beberapa kategori sekaligus.
     */
    public function bulkDestroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return back()->with('error', __('No items selected for deletion.'));
            }

            $this->model->whereIn('id', $ids)->delete();

            DB::commit();
            return redirect()
                ->back()
                ->with('success', __('Selected categories deleted successfully.'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}