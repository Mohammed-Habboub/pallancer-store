<x-dashboard-layout title="Edit Categoryt">

        <form action="{{route('admin.categories.update', $id)}}" method="POST" enctype="multipart/form-data">
                <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{ csrf_field() }} -->
                @csrf

                <!-- <input type="hidden" name="_method" value="put"> -->
                @method('put')

                @include('admin.categories._form', [
                'button_lable' => 'update'
                ])

        </form>


</x-dashboard-layout>