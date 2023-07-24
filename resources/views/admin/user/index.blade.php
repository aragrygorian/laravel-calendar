<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-end mb-5">
                        <div class="d-inline-block dropdown">
                          <button  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <a href="{{ route('user.create') }}">
                              Add User
                            </a>
                        </button>
                        </div>
                      </div>
                      @include('partial.error')

                    <div class="card">
                        <h5 class="card-header">User List</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach($users as $user)
                                     <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name ?? '' }}</td> 
                                        <td>{{ $user->email ?? '' }}</td>
                                        <td>{{ $user->phone ?? '' }}</td>
                                        <td>{{ ucfirst($user->roles()->first()?->name) }}</td>
                                        <td><img src="{{ asset('storage/'.$user->image) }}" width="100" height="100" class="rounded"></td>
                                        <td>
                                           <ul class="nav">
                                                  <li class="nav-item">
                                                    <form  method="GET" action="{{ route('user.edit',$user->id) }}">
                                                    <button  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                      Edit
                                                  </button>
                                                </form>

                                                  </li>
                                                  <li class="nav-item">
                                                    <form method="POST" action="{{ route('user.destroy',$user->id) }}">
                                                      @csrf
                                                     @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                     Delete
                                                  </button>
                                                </form>
                                                  </li>
                                                </ul>
                                          </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
function delete_service(el){
  console.log(el);
  let link=$(el).data('id');
  $('.deleted-modal').modal('show');
  $('#delete_form').attr('action', link);
}
</script>