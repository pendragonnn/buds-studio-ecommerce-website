<div class="bg-white shadow rounded-xl p-6" x-data="{ mode: 'add', user: {} }">

  <h3 class="text-lg font-semibold mb-4">User Management</h3>

  {{-- Form Add / Edit User --}}
  <form :action="mode === 'add' ? '{{ route('admin.users.store') }}' : '/admin/users/' + user.id" method="POST"
    class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    @csrf
    <template x-if="mode === 'edit'">
      <input type="hidden" name="_method" value="PUT">
    </template>

    {{-- Role dropdown --}}
    <select required name="role_id" class="border px-4 py-2 rounded-lg col-span-2 md:col-span-1">
      <option value="">-- Select Role --</option>
      @foreach ($roles as $role)
        <option value="{{ $role->id }}" x-bind:selected="user.role_id == {{ $role->id }}">
          {{ ucfirst($role->name) }}
        </option>
      @endforeach
    </select>

    <input type="text" name="name" placeholder="Full Name" x-model="user.name" class="border px-4 py-2 rounded-lg">
    <input type="email" name="email" placeholder="Email" x-model="user.email" class="border px-4 py-2 rounded-lg">
    <input :required="mode === 'add'" type="password" name="password" placeholder="Password (leave blank if unchanged)"
      class="border px-4 py-2 rounded-lg">
    <input type="text" name="phone" placeholder="Phone Number" x-model="user.phone" class="border px-4 py-2 rounded-lg">
    <textarea name="address" placeholder="Address" x-model="user.address"
      class="border px-4 py-2 rounded-lg col-span-2"></textarea>

    <div class="col-span-2 flex justify-between">
      {{-- Tombol reset ke mode add --}}
      <button type="button" @click="mode = 'add'; user = {}" class="bg-gray-300 px-6 py-2 rounded-lg">
        Reset
      </button>

      <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600"
        x-text="mode === 'add' ? 'Add User' : 'Update User'">
      </button>
    </div>
  </form>

  {{-- Table Users --}}
  <div class="overflow-x-auto rounded-lg border border-gray-200 p-4">
    <table id="usersTable" class="min-w-full text-sm text-gray-700 mb-4">
      <thead>
        <tr class="bg-gradient-to-r from-pink-50 to-rose-50 text-gray-600 uppercase text-xs tracking-wider">
          <th class="px-4 py-3 text-center font-semibold">Name</th>
          <th class="px-4 py-3 text-center font-semibold">Email</th>
          <th class="px-4 py-3 text-center font-semibold">Role</th>
          <th class="px-4 py-3 text-center font-semibold">Phone</th>
          <th class="px-4 py-3 text-center font-semibold">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @foreach ($users as $u)
          <tr class="hover:bg-pink-50 transition">
            <td class="px-4 py-3 text-center font-medium text-gray-800">{{ $u->name }}</td>
            <td class="px-4 py-3 text-center">{{ $u->email }}</td>
            <td class="px-4 py-3 text-center">{{ ucfirst($u->role->name) }}</td>
            <td class="px-4 py-3 text-center">{{ $u->phone }}</td>
            <td class="px-4 py-3 flex flex-wrap gap-2 justify-center">
              <button type="button" @click="mode = 'edit'; user = {{ $u->toJson() }}"
                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Edit
              </button>
              <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- DataTables init --}}
<script>
  $(document).ready(function () {
    let table = $('#usersTable').DataTable({
      pageLength: 10,
      responsive: true,
      dom: '<"flex flex-col md:flex-row items-center justify-between gap-4 mb-4"f>t<"flex flex-col md:flex-row items-center justify-between gap-4 mt-4"lip>',
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search by name...",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ users",
        paginate: {
          previous: "← Prev",
          next: "Next →"
        }
      },
      columnDefs: [
        { orderable: false, targets: -1 }, // kolom Actions non-sortable
      ],
      order: [[0, "asc"]] // urut default berdasarkan Name
    });

    // Override search → hanya ke kolom Name (index 0)
    $('#usersTable_filter input').off().on('keyup change', function () {
      table.column(0).search(this.value).draw();
    });

    // Styling selaras
    $('div.dataTables_filter input').addClass('px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 w-64');
    $('div.dataTables_length select').addClass('px-2 py-1 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 focus:border-pink-400');
  });
</script>