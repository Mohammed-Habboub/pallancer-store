<x-dashboard-layout title="Add Product" >


        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.products._form', [
                'button_lable' => 'Add'
        ])
            

    </form>

</x-dashboard-layout>