<x-app-layout>
    <div>
        <form action="{{ route('updateTask', $dTask->id) }}" method="POST" class="ml-5 mt-9 mb-9 mr-7">
            @csrf
            @method('PUT')
    
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium">Assign To</label>
                <select name="status" 
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" >
                    @foreach ($pTaskStatuses as $status)
                        <option value="{{ $status->status }}" 
                            {{ ($status->status == $dTask->status) ? 'selected' : '' }}>
                            {{ $status->entitled }}
                        </option>
                    @endforeach
                </select>
            </div>
    
    
            <button type="submit" 
                    class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">
                Submit
            </button>
        </form>
    </div>
    </x-app-layout>
    