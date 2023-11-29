<style>
    .container {
        margin: 20px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #ffffff;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h1>Hello.... {{ auth()->user()->name }}</h1>
        <button>
            <a href="{{ route('addCategory') }}">Add Category</a>
        </button>
        <div class="container">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Added by admin:</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Deleted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                        alt="img" class="img-thumbnail">
                                @else
                                    <img src="placeholder.jpg" alt="img" class="img-thumbnail">
                                @endif
                            </td>
                            <td>{{ $category->user_id }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>{{ $category->deleted_at }}</td>
                            <td class="actions">
                                <div class="btn-group">
                                    <form method="get" action="{{ route('editCategory', $category) }}">

                                        @csrf
                                        <button type="submit"
                                            class="btn btn-primary ml-2">Edit</button>
                                    </form>

                                    <form method="post"
                                        action="{{ route('deleteCategory', ['category' => $category]) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-primary ml-2">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            
        </div>

         <div class="container">
            <h1>Deleted Categories</h1>
            <table class="table">
                <!-- Fetch only deleted categories -->
                @php
                    $deletedCategories = \App\Models\Category::onlyTrashed()->get();
                @endphp
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Added by admin:</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Deleted At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deletedCategories as $deletedCategory)
                        <tr>
                            <td>{{ $deletedCategory->category_name }}</td>
                            <td> @if ($deletedCategory->image)
                                <img src="{{ asset('storage/' . $deletedCategory->image) }}"
                                    alt="img" class="img-thumbnail">
                            @else
                                <img src="placeholder.jpg" alt="img" class="img-thumbnail">
                            @endif</td>
                            <td>{{ $deletedCategory->user_id }}</td>
                            <td>{{ $deletedCategory->created_at }}</td>
                            <td>{{ $deletedCategory->updated_at }}</td>
                            <td>{{ $deletedCategory->deleted_at }}</td>
                            <td class="actions">
                                <div class="btn-group">
                                    <!-- Your existing edit and delete buttons -->
                
                                    <form method="post" action="{{ route('restoreCategory', ['id' => $deletedCategory->id]) }}"  onsubmit="return confirm('Are you sure you want to restore this category?')">
                                        @csrf
                                        <button type="submit" class="btn btn-success ml-2">Restore</button>
                                    </form>
                                </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
