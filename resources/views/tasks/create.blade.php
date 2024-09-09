<x-app-layout>

<div>
   
<form action="{{ route('storeTask') }}" method="POST" class="ml-5 mt-9 mb-9 mr-7">
    @csrf
          <div class="mb-6">
            <label  class="block mb-2 text-sm font-medium ">title</label>
            <input type="text"  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="title"  name='title' >
         
          </div>       
          <div class="mb-6">
            <label  class="block mb-2 text-sm font-medium ">description</label>
            <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  name='description' ></textarea>
           
          </div>
          <div class="mb-6">
              <label  class="block mb-2 text-sm font-medium ">assign To</label>
              <select name="users[]" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" 
                        >
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
          
          
            </div>
            <div class="mb-6">
              <label  class="block mb-2 text-sm font-medium " >date</label>
              <input type="date" name='date' class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " >
            
          </div>
     
         
          <button type="submit"  class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
        </form>
</div>
</x-app-layout>