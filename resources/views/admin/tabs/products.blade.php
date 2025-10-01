<div class="bg-white shadow rounded-xl p-6" x-data="{ mode: 'add', product: {}, openDelete: false }">

  <h3 class="text-lg font-semibold mb-4">Product Management</h3>

  {{-- Form Add / Edit Product --}}
  <form :action="mode === 'add' ? '{{ route('admin.products.store') }}' : '/admin/products/' + product.id" method="POST"
    enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    @csrf
    <template x-if="mode === 'edit'">
      <input type="hidden" name="_method" value="PUT">
    </template>

    <input required type="text" name="name" placeholder="Product Name" x-model="product.name"
      class="border px-4 py-2 rounded-lg">

    <input required type="number" name="price" placeholder="Price (Rp)" x-model="product.price"
      class="border px-4 py-2 rounded-lg">

    <input required type="number" name="stock" placeholder="Stock" x-model="product.stock"
      class="border px-4 py-2 rounded-lg">

    {{-- Dropdown categories --}}
    <select required name="category_id" class="border px-4 py-2 rounded-lg">
      <option value="">-- Select Category --</option>
      @foreach ($categories as $cat)
        <option value="{{ $cat->id }}" x-bind:selected="product.category_id == {{ $cat->id }}">
          {{ $cat->name }}
        </option>
      @endforeach
    </select>

    <input required type="text" name="description" placeholder="Description" x-model="product.description"
      class="border px-4 py-2 rounded-lg col-span-2">

    <div class="col-span-2">
      <label class="block text-sm font-medium mb-1">Product Image</label>
      <input :required="mode === 'add'" type="file" name="image" class="w-full border px-4 py-2 rounded-lg">
    </div>

    <div class="col-span-2 flex justify-between">
      {{-- Reset ke mode add --}}
      <button type="button" @click="mode = 'add'; product = {}" class="bg-gray-300 px-6 py-2 rounded-lg">
        Reset
      </button>

      <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600"
        x-text="mode === 'add' ? 'Add Product' : 'Update Product'">
      </button>
    </div>
  </form>

  {{-- Table --}}
  <div class="overflow-x-auto rounded-lg border border-gray-200 p-4">
    <table id="productsTable" class="min-w-full text-sm text-gray-700 mb-4">
      <thead>
        <tr class="bg-gradient-to-r from-pink-50 to-rose-50 text-gray-600 uppercase text-xs tracking-wider">
          <th class="px-4 py-3 text-center font-semibold">Image</th>
          <th class="px-4 py-3 text-center font-semibold">Name</th>
          <th class="px-4 py-3 text-center font-semibold">Price</th>
          <th class="px-4 py-3 text-center font-semibold">Stock</th>
          <th class="px-4 py-3 text-center font-semibold">Category</th>
          <th class="px-4 py-3 text-center font-semibold">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach ($products as $p)
          <tr class="hover:bg-pink-50 transition">
            <td class="px-4 py-2 text-center">
              <img src="{{ asset('storage/' . $p->image_url) }}" class="w-10 h-10 object-cover rounded-lg mx-auto">
            </td>
            <td class="px-4 py-2 text-center font-medium text-gray-800">{{ $p->name }}</td>
            <td class="px-4 py-2 text-center font-semibold text-pink-600">
              Rp {{ number_format($p->price, 0, ',', '.') }}
            </td>
            <td class="px-4 py-2 text-center">{{ $p->stock }}</td>
            <td class="px-4 py-2 text-center">{{ $p->category->name }}</td>
            <td class="px-4 py-2 text-center">
              <div class="flex justify-center gap-2">
                <button @click="mode = 'edit'; product = {{ $p->toJson() }}" type="button"
                  class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                  Edit
                </button>
                <button @click="openDelete = true; product = {{ $p->toJson() }}" type="button"
                  class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                  Delete
                </button>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
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

{{-- DataTables init --}}
<script>
  $(document).ready(function () {
    let table = $('#productsTable').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"flex flex-col md:flex-row items-center justify-between gap-4 mb-4"f>t<"flex flex-col md:flex-row items-center justify-between gap-4 mt-4"lip>',
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search product name...",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ products",
        paginate: {
          previous: "← Prev",
          next: "Next →"
        }
      },
      columnDefs: [
        { orderable: false, targets: [0, -1] }, // Image & Actions non-sortable
      ],
      order: [[1, "asc"]], // default order by Name (col 1)
    });

    // Override pencarian biar hanya di kolom "Name" (index 1)
    $('#productsTable_filter input').off().on('keyup change', function () {
      table.column(1).search(this.value).draw();
    });
  });
</script>