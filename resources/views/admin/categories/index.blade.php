
<x-dashboard-layout title="Categories" subtitle="sub title">
    
@can('create', App\Models\Category::class)
    <div class="table toolbar mb-3">
    @include('components.alert')

        <a href="{{ route('admin.categories.create') }}" class="btn btn-info">Create</a>
    </div>
    @endcan
    <!-- route('admin.categories.index') == URL::current() -->
    <form action="{{URL::current()}}" method="get" class="d-flex mb-4">
        <input type="text" name="name" class="form-control me-2" placeholder="Search by name">
        <select name="parent_id" class="form-control me-2">
            <option value="">All categories</option>
            @foreach ($parents as $parent)
            <option value="{{$parent->id}}"> {{ $parent->name }} </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent Name</th>
                <th>Created At</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id; }}</td>
                <td><a href="{{ route('admin.categories.edit', $category->id) }}">{{ $category->name; }}</a></td>
                <!-- <td>{{ $category->parent_name; }}</td> // use leftjoin  -->
                <td>{{ $category->parent->name; }}</td><!--  use Relation in model category -->
                <td>{{ $category->created_at; }}</td>
                <td>{{ $category->status; }}</td>
                <td>
                {{-- @if(Auth::user()->can('delete', $category)) --}}
                    
                    <form action="{{ route('admin.categories.destroy', $category->id )}}" method="post">
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
</x-dashboard-layout>