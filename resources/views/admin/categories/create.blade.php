<x-dashboard-layout title="Add Categoryt" >


        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.categories._form', [
                'button_lable' => 'Add'
        ])
            

    </form>

</x-dashboard-layout>