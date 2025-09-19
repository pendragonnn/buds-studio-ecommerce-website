<div class="bg-white shadow rounded-xl p-6" x-data="{ openEdit: false, openDelete: false, product: {} }">
  <h3 class="text-lg font-semibold mb-4">Product Management</h3>

  {{-- Form Add Product --}}
  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
    class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    @csrf
    <input required type="text" name="name" placeholder="Product Name" class="border px-4 py-2 rounded-lg">
    <input required type="number" name="price" placeholder="Price (Rp)" class="border px-4 py-2 rounded-lg">
    <input required type="number" name="stock" placeholder="Stock" class="border px-4 py-2 rounded-lg">

    {{-- Dropdown categories --}}
    <select required name="category_id" class="border px-4 py-2 rounded-lg">
      <option value="">-- Select Category --</option>
      @foreach ($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
      @endforeach
    </select>

    <input required type="text" name="description" placeholder="Description"
      class="border px-4 py-2 rounded-lg col-span-2">

    <div class="col-span-2">
      <label class="block text-sm font-medium mb-1">Product Image</label>
      <input required type="file" name="image" class="w-full border px-4 py-2 rounded-lg">
    </div>

    <div class="col-span-2 flex justify-end">
      <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
        Add Product
      </button>
    </div>
  </form>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">Image</th>
          <th class="px-4 py-2">Name</th>
          <th class="px-4 py-2">Price</th>
          <th class="px-4 py-2">Stock</th>
          <th class="px-4 py-2">Category</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $p)
          <tr class="hover:bg-gray-50"> {{-- Tambahkan efek hover untuk visual yang lebih baik --}}
            {{-- Kolom Gambar: tengah horizontal dan vertikal --}}
            <td class="px-4 py-2 text-center">
              <div class="flex items-center justify-center">
                <img src="{{ asset('storage/' . $p->image_url) }}" class="w-10 h-10 object-cover rounded-lg">
              </div>
            </td>
            {{-- Kolom Nama: kiri --}}
            <td class="px-4 py-2 text-center">{{ $p->name }}</td>
            {{-- Kolom Harga: kiri (atau kanan untuk angka) --}}
            <td class="px-4 py-2 text-center">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
            {{-- Kolom Stok: kiri --}}
            <td class="px-4 py-2 text-center">{{ $p->stock }}</td>
            {{-- Kolom Kategori: kiri --}}
            <td class="px-4 py-2 text-center">{{ $p->category->name }}</td>
            {{-- Kolom Aksi: tengah --}}
            <td class="px-4 py-2 text-center">
              <div class="flex justify-center items-center gap-2">
                {{-- Trigger Modal Edit --}}
                <button @click="openEdit = true; product = {{ $p->toJson() }}" type="button"
                  class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300 transition-colors">
                  Edit
                </button>

                {{-- Trigger Modal Delete --}}
                <button @click="openDelete = true; product = {{ $p->toJson() }}" type="button"
                  class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                  Delete
                </button>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Modal --}}
  <div x-show="openEdit" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
      <h2 class="text-lg font-bold mb-4">Edit Product</h2>

      <form action="{{ route('admin.products.update', $p->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="name" x-model="product.name" class="border px-4 py-2 w-full mb-2 rounded-lg">

        <input type="number" name="price" x-model="product.price" class="border px-4 py-2 w-full mb-2 rounded-lg">

        <input type="number" name="stock" x-model="product.stock" class="border px-4 py-2 w-full mb-2 rounded-lg">

        <select name="category_id" class="border px-4 py-2 w-full mb-2 rounded-lg">
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" x-bind:selected="product.category_id == {{ $cat->id }}">
              {{ $cat->name }}
            </option>
          @endforeach
        </select>

        <textarea name="description" x-model="product.description"
          class="border px-4 py-2 w-full mb-2 rounded-lg"></textarea>

        <input type="file" name="image" class="w-full border px-4 py-2 mb-4 rounded-lg">

        <div class="flex justify-end gap-2">
          <button type="button" @click="openEdit = false" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg">Update</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Delete Confirm Modal --}}
  <div x-show="openDelete" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-sm text-center">
      <h2 class="text-lg font-bold mb-4">Delete Product</h2>
      <p class="mb-6">Are you sure you want to delete
        <span class="font-semibold text-red-600" x-text="product.name"></span>?
      </p>

      <form :action="'/admin/products/' + product.id" method="POST" class="flex justify-center gap-2">
        @csrf
        @method('DELETE')
        <button type="button" @click="openDelete = false" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
      </form>
    </div>
  </div>
</div>