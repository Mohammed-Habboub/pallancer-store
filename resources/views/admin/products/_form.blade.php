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
        <input type="text" name='name' value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Category: </label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror ">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" @if($category->id == old('category_id', $product->category_id)) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Description: </label>
        <textarea name='description' class="form-control  @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
        @error('description')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Image: </label>
        <div class="mb-2">
        <img src="{{ $product->image_url }}" height="200" alt="">
        </div>     
        
        <input type="file" name='image'  class="form-control @error('image') is-invalid @enderror">
        @error('image')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Gallery: </label>
        <div class="row">
            @foreach ($product->images as $image)
            <div class="col-md-2">
            <img src="{{ $product->image_url }}" class="img-fit m-1 border p-1" height="120" alt="">
            </div>
            @endforeach
        </div>  
        
        <input type="file" name='gallery[]' multiple  class="form-control @error('gallery') is-invalid @enderror">
        @error('gallery')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>



    <div class="form-group mb-4">
        <label for="">Price: </label>
        <input type="number" name='price' value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror">
        @error('price')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Sale Price: </label>
        <input type="number" name='sale_price' value="{{ old('sale_price', $product->sale_price) }}" class="form-control @error('sale_price') is-invalid @enderror">
        @error('sale_price')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Quantity: </label>
        <input type="number" name='quantity' value="{{ old('quantity', $product->quantity) }}" class="form-control @error('quantity') is-invalid @enderror">
        @error('quantity')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Tags: </label>
        <input type="text" name='tags' value="{{ old('tags', $tags) }}" class="tagify form-control @error('tags') is-invalid @enderror">
        @error('tags')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="">Status: </label>
        <div>
            <!-- we  can use blade tamblet -->
            <label for=""><input type="radio" name='status' value="in-stok" <?php if (old('status', $product->status) == 'in-stok') : ?>checked <?php endif ?>>in-stok</label>
            <label for=""><input type="radio" name='status' value="sold-out" <?php if (old('status', $product->status) == 'sold-out') : ?>checked <?php endif ?>>sold-out</label>
                <label for=""><input type="radio" name='status' value="draft" <?php if (old('status', $product->status) == 'draft') : ?>checked <?php endif ?>>draft</label>
        </div>
        @error('status')
        <p class="invalid-feedback d-blok">{{ $message }}</p>
        @enderror
    </div class="form-group mb-4">

    <div>
        <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'save' }}</button>
    </div>
    </div>
    @push('css')
    <link rel="stylesheet" href="{{ asset('js/tagify/tagify.css') }}">
    @endpush
    
    @push('js')
    <script src="{{ asset('js/tagify/tagify.min.js') }}"></script>
    <script>
        var inputElm = document.querySelector('.tagify'),
            tagify = new Tagify (inputElm);
    </script>
    @endpush