<div class="col-sm-12">
    {{-- Category Name --}}
    <div class="mb-3">
        <label>Category Name <span class="text-danger">*</span></label>
        <input class="form-control" type="text" name="name"
               value="{{ isset($category->name) ? $category->name : old('name') }}"
               placeholder="Enter Category Name">
        @error('name')
            <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    {{-- Category Type --}}
    <div class="mb-3">
        <label>Category Type <span class="text-danger">*</span></label>
        <select class="form-select" name="type" required>
            <option value="" disabled {{ !isset($category->type) ? 'selected' : '' }}>-- Select Type --</option>
            <option value="income" {{ old('type', $category->type ?? '') == 'income' ? 'selected' : '' }}>Income</option>
            <option value="expense" {{ old('type', $category->type ?? '') == 'expense' ? 'selected' : '' }}>Expense</option>
        </select>
        @error('type')
            <span class="text-danger d-block"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="text-end">
        <a href="{{ route('admin.category.index') }}" class="btn btn-danger">
            <i class="ti ti-arrow-left me-1"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i> Save
        </button>
    </div>
</div>
