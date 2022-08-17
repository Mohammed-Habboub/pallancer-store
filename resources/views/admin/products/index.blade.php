
<x-dashboard-layout title="Products">
    <div class="table toolbar mb-3">
    @include('components.alert')

        <a href="{{ route('admin.products.create') }}" class="btn btn-info">Create</a>
    </div>
    <!-- route('admin.categories.index') == URL::current() -->
    <form action="{{URL::current()}}" method="get" class="d-flex mb-4">
        <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
        <select name="parent_id" class="form-control me-2">
            <option value="">All categories</option>
            @foreach ($categorise as $category)
            <option value="{{$category->id}}"> {{ $category->name }} </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Categories</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Created At</th>
               
                <th></th>
            </tr>
        </thead>

        <tbody>

            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->name }}</a></td>
                <!-- <td>{{ $category->parent_name; }}</td> // use leftjoin  -->
                <td>{{ $product->category->name }}</td><!--  use Relation in model category -->
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity}}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->created_at }}</td>
                <td>
                    <form action="{{ route('admin.products.destroy', $product->id )}}" method="post">
                        @csrf
                        <!-- {{ csrf_field(); }} -->
                        @method('delete')
                        <!-- <input type="hidden" name="_method" value="delete"> -->
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>


                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{$products->links()}}<!-- use to paginat() only -->
</x-dashboard-layout>