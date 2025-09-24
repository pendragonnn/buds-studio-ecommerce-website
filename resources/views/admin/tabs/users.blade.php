<div class="bg-white shadow rounded-xl p-6" 
     x-data="{ mode: 'add', user: {} }">

  <h3 class="text-lg font-semibold mb-4">User Management</h3>

  {{-- Form Add / Edit User --}}
  <form :action="mode === 'add' ? '{{ route('admin.users.store') }}' : '/admin/users/' + user.id" 
        method="POST" 
        class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    @csrf
    <template x-if="mode === 'edit'">
      <input type="hidden" name="_method" value="PUT">
    </template>

    {{-- Role dropdown --}}
    <select required name="role_id" class="border px-4 py-2 rounded-lg col-span-2 md:col-span-1">
      <option value="">-- Select Role --</option>
      @foreach ($roles as $role)
        <option value="{{ $role->id }}" 
                x-bind:selected="user.role_id == {{ $role->id }}">
          {{ ucfirst($role->name) }}
        </option>
      @endforeach
    </select>

    <input type="text" name="name" placeholder="Full Name" 
           x-model="user.name" 
           class="border px-4 py-2 rounded-lg">
    <input type="email" name="email" placeholder="Email" 
           x-model="user.email"
           class="border px-4 py-2 rounded-lg">
    <input :required="mode === 'add'" type="password" name="password" 
           placeholder="Password (leave blank if unchanged)" 
           class="border px-4 py-2 rounded-lg">
    <input type="text" name="phone" placeholder="Phone Number" 
           x-model="user.phone" 
           class="border px-4 py-2 rounded-lg">
    <textarea name="address" placeholder="Address"
              x-model="user.address"
              class="border px-4 py-2 rounded-lg col-span-2"></textarea>

    <div class="col-span-2 flex justify-between">
      {{-- Tombol reset ke mode add --}}
      <button type="button" 
              @click="mode = 'add'; user = {}" 
              class="bg-gray-300 px-6 py-2 rounded-lg">
        Reset
      </button>

      <button type="submit" 
              class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600"
              x-text="mode === 'add' ? 'Add User' : 'Update User'">
      </button>
    </div>
  </form>

  {{-- Table Users --}}
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2">Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Role</th>
          <th class="px-4 py-2">Phone</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $u)
          <tr>
            <td class="px-4 py-2">{{ $u->name }}</td>
            <td class="px-4 py-2">{{ $u->email }}</td>
            <td class="px-4 py-2">{{ $u->role->name }}</td>
            <td class="px-4 py-2">{{ $u->phone }}</td>
            <td class="px-4 py-2 flex gap-2">
              {{-- Tombol Edit --}}
              <button type="button"
                      @click="mode = 'edit'; user = {{ $u->toJson() }}"
                      class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-300">
                Edit
              </button>

              {{-- Tombol Delete --}}
              <form action="{{ route('admin.users.destroy', $u->id) }}" 
                    method="POST" 
                    onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
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
