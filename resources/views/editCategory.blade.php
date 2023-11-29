<x-app-layout>
    <x-slot name="header">

    <div class="container" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
        <h1 style="text-align: center;">Create Category</h1>
        <form action="{{ route('updateCategory', ['category' => $category]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="category_name" style="font-weight: bold;">Category Name</label>
                <input type="text" name="category_name" id="category_name" value="{{ $category->category_name}}" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
         
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="image" style="font-weight: bold;">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="image" style="font-weight: bold;">Current Image:</label>
                <img class="img-thumbnail" src="{{ asset('storage/' . $category->image) }}"
                alt="Current Image">
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Save Category</button>
           
        </form>
    </div>
</x-slot>
</x-app-layout>