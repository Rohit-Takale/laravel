<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Create new list') }}
                    </h2>
                    <!-- <form action="{{route('todo_insert')}}" method="post">
                        @csrf -->
                    <div class="error my-5"></div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="name" :value="__('Task Name')" />
                            <x-text-input id="cname" class="block mt-1 w-full t_name" type="text" name="task_name" :value="old('tname')" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Task date')" />
                            <x-text-input id="cname" class="block mt-1 w-full t_date" type="date" name="task_date" :value="old('tdate')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 mt-5">
                        <div>
                            <x-input-label for="name" :value="__('Description')" />
                            <textarea name="task_desc" id="descr" rows="4" class="descr block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="breif intro on your todo task..."></textarea>
                        </div>

                        <div>
                            <x-primary-button type="submit" class="" id="todo_sub">
                                {{ __('Submit Todo') }}
                            </x-primary-button>

                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-5">
                            {{ __('Created lists') }}
                        </h2>

                        <div class="grid grid-cols-4 gap-5">

                                <div class="max-w-sm rounded bg-red-400 overflow-hidden shadow-lg shadow-sm sm:rounded-lg">
                                    <div class="px-6 py-4">
                                        <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                                        <p class="text-gray-700 text-base">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                                        </p>
                                    </div>
                                    <div class="px-6 pt-4 pb-2">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('js/jquery.js')}}"></script>
        <script>
            $(document).ready(function() {
                $("#todo_sub").click(function(e) {
                    e.preventDefault();
                    var t_name = "",
                        t_date = "",
                        t_desc = "";
                    t_name = $(".t_name").val();
                    t_date = $(".t_date").val();
                    t_desc = $(".descr").val();
                    console.log(t_name, t_date, t_desc);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    if (t_name != "" && t_date != "" && t_desc != "") {
                        $.ajax({
                            type: "POST",
                            url: "{{route('todo_insert')}}",
                            data: {
                                task_name: t_name,
                                task_date: t_date,
                                task_desc: t_desc
                            },
                            dataType: "JSON",
                            success: function(response) {}
                        });
                        $(".t_name").val("");
                        $(".t_date").val("");
                        $(".descr").val("");
                        $(".error").html("created");
                    } else {
                        $(".error").html("Some fields are missing");
                    }

                });
            });
        </script>

</x-app-layout>