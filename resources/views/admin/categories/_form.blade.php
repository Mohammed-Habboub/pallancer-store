<div class="form-group mb-4">
        <label for="">Name: </label>
        <input type="text" name='name' value="{{ $category->name }}" class="form-control">
    </div>

    <div class="form-group mb-4">
        <label for="">Parents: </label>
        <select name="parent_id" class="form-control">
            <option value="">No parant</option>
            @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @if ($category->parent_id == $parent->id) selected @endif>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-4">
        <label for="">Description: </label>
        <textarea name='description' class="form-control">{{ $category->description }}</textarea>
    </div>

    <div class="form-group mb-4">
        <label for="">Image: </label>
        <input type="file" name='image' value="{{ $category->image }}" class="form-control">
    </div>

    <div class="form-group mb-4">
        <label for="">Status: </label>
        <div>
            <!-- we  can use blade tamblet -->
            <label for=""><input type="radio" name='status' value="active" <?php if ($category->status == 'active') : ?>checked <?php endif ?>>Active</label>
            <label for=""><input type="radio" name='status' value="inactive" <?php if ($category->status == 'inactive') : ?>checked <?php endif ?>>Inactive</label>
        </div>
    </div class="form-group mb-4">

    <div>
        <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'save' }}</button>
    </div>
    </div>