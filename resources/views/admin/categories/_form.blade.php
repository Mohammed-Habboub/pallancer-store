@if ($errors->any())
    <div class="alert alert-danger">
        Error!
        <ul>
            @foreach ($errors->all() as $message)
            <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group mb-4">
        <label for="">Name: </label>
        <input type="text" name='name' value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Parents: </label>
        <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror ">
            <option value="">No parant</option>
            @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @if ( old('parent_id', $category->parent_id) == $parent->id) selected @endif>{{ $parent->name }}</option>
            @endforeach
        </select>
        @error('parent_id')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Description: </label>
        <textarea name='description' class="form-control  @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
        @error('description')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Image: </label>
        <input type="file" name='image' value="{{ $category->image }}" class="form-control @error('image') is-invalid @enderror">
        @error('image')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Status: </label>
        <div>
            <!-- we  can use blade tamblet -->
            <label for=""><input type="radio" name='status' value="active" <?php if (old('status', $category->status) == 'active') : ?>checked <?php endif ?>>Active</label>
            <label for=""><input type="radio" name='status' value="inactive" <?php if (old('status', $category->status) == 'inactive') : ?>checked <?php endif ?>>Inactive</label>
        </div>
        @error('status')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div class="form-group mb-4">

    <div>
        <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'save' }}</button>
    </div>
    </div>