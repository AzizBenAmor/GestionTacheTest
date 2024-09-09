<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class=" mx-auto max-w-screen-xl ">
                        
                        <!-- Start coding here -->
                        <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
                            <div class=" mb-6">
                                <a href='{{ route('createTask') }}' type="button" class=" mt-5 text-black bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Add Task</a>
                               </div>
                            <div class="flex items-center justify-between d p-4">
                                <div class="flex">
                                    <div class="relative w-full">
                                      
                                            <form action="{{ route('dashboard') }}" method="GET">
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit">En Attend</button>
                                            </form>
                                            <form action="{{ route('dashboard') }}" method="GET">
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit">en cours</button>
                                            </form>
                                            <form action="{{ route('dashboard') }}" method="GET">
                                                <input type="hidden" name="status" value="2">
                                                <button type="submit">Terminer</button>
                                            </form>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 ">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                       
                                            
                                       
                                        <tr>
                                      
                                          <th scope="col" class="px-4 py-3">
                                                Title
                                          </th>
                                          <th scope="col" class="px-4 py-3">
                                            Description
                                          </th>
                                          <th scope="col" class="px-4 py-3">
                                            Date
                                          </th>
                                          <th scope="col" class="px-4 py-3">
                                            Status
                                          </th>
                                    
                                            <th scope="col" class="px-4 py-3">
                                              Actions
                                            </th>
                                        </tr>
                                    </thead>                           
                                    <tbody>
                                        @foreach ($dTasks as $task)
                                        <tr class="border-b ">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ $task->title }}</th>
                                            <td class="px-4 py-3"> {{ $task->description }}</td>
                                            <td class="px-4 py-3">{{ $task->date }}</td>
                                            <td class="px-4 py-3">{{ $task->statusTask->entitled }}</td>
                                            <td class="px-4 py-3 flex items-center justify-even">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('status',$task->id) }}"  class="px-3 py-1 bg-gray-700 text-black rounded">change state</a>
                                                    @php
                                                        $user=auth()->user();    
                                                    @endphp 
                                                        <a href="{{ route('editTask',$task->id) }}"  class="px-3 py-1 bg-gray-700 text-black rounded">Edit</a> 
                                                        <form action="{{ route('deleteTask', $task->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">X</button>
                                                        </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             
                            </div>
            
                          
                            {{ $dTasks->links() }}
                           
                            
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
