<div class="bg-white shadow rounded-xl p-6">
  <h3 class="text-lg font-semibold mb-4">Product Management</h3>

  {{-- Form --}}
  <form class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <input type="text" placeholder="Product Name" class="border px-4 py-2 rounded-lg">
    <input type="number" placeholder="Price (Rp)" class="border px-4 py-2 rounded-lg">
    <input type="number" placeholder="Stock" class="border px-4 py-2 rounded-lg">
    <input type="text" placeholder="Category" class="border px-4 py-2 rounded-lg">
    <input type="text" placeholder="Description" class="border px-4 py-2 rounded-lg col-span-2">

    <div class="col-span-2">
      <label class="block text-sm font-medium mb-1">Product Image</label>
      <input type="file" class="w-full border px-4 py-2 rounded-lg">
    </div>

    <div class="col-span-2 flex justify-end">
      <button type="button" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600">
        Add Product
      </button>
    </div>
  </form>

  {{-- Table --}}
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">Image</th>
          <th class="px-4 py-2 text-left">Name</th>
          <th class="px-4 py-2 text-left">Price</th>
          <th class="px-4 py-2 text-left">Stock</th>
          <th class="px-4 py-2 text-left">Category</th>
          <th class="px-4 py-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @for ($i = 1; $i <= 10; $i++)
          <tr>
            <td class="px-4 py-2">
              <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full">
            </td>
            <td class="px-4 py-2">Blush Bloom Nails</td>
            <td class="px-4 py-2">Rp 75.000</td>
            <td class="px-4 py-2">10</td>
            <td class="px-4 py-2">{{ $i % 2 === 0 ? 'phone-strap' : 'press-on-nails' }}</td>
            <td class="px-4 py-2 flex gap-2">
              <button class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300">Edit</button>
              <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">Delete</button>
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>