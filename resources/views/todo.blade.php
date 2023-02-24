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
                    <!-- <form action="{{ route('todo_insert') }}" method="post">
                        @csrf -->
                    <div class="error my-5"></div>
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <x-input-label for="name" :value="__('Task Name')" />
                            <x-text-input id="cname" class="block mt-1 w-full t_name" type="text"
                                name="task_name" :value="old('tname')" required autofocus />
                        </div>

                    </div>

                    <div class="grid grid-cols-1 gap-5 mt-5 ">
                        <div>
                            <x-input-label for="name" :value="__('Description')" />
                            <textarea name="task_desc" id="descr" rows="4"
                                class="descr block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="breif intro on your todo task..."></textarea>
                        </div>

                        <div class="main-btn-div">
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

                        <div class="grid grid-cols-3 gap-5 crtd_list" id="crtd_list">


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            // $("html, body").animate({ scrollbottom: $("#crtd_list").scrollbottom() }, 1000);
            $("#crtd_list").scrollTop(1000);
            $("#todo_sub").click(function(e) {
                e.preventDefault();
                var t_name = "",
                    t_desc = "";
                t_name = $(".t_name").val();
                t_desc = $(".descr").val();
                console.log(t_name, t_desc);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if (t_name != "" && t_desc != "") {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('todo_insert') }}",
                        data: {
                            task_name: t_name,
                            task_desc: t_desc
                        },
                        dataType: "JSON",
                        success: function(response) {}
                    });
                    $(".t_name").val("");
                    $(".descr").val("");
                    $(".error").html("Task Created Sucessfully");

                    display();
                } else {
                    $(".error").html("Some fields are missing");
                }
            });


            function display() {
                $.ajax({
                    type: "get",
                    url: "{{ route('get_todo_data') }}",
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response.values);
                        var list2 = response.values;
                        $(".crtd_list").html("");
                        $.each(list2, function(ind, val) {
                            $(".crtd_list").append(`<div class="max-w-sm rounded bg-red-400 overflow-hidden shadow-lg shadow-sm sm:rounded-lg ${"card" + val.id}" id="${"card" + val.id}">
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2">${val.task_name}</div>
                                    <p class="text-gray-700 text-base">
                                       ${val.task_desc}
                                    </p>
                                   
                                </div>
                                <div class="px-6 pt-4 pb-2">
                                    <x-primary-button type="submit" class="edtbtn" id="edtbtn" value="${val.id}">
                                        {{ __('Edit') }}
                                    </x-primary-button>

                                    <x-primary-button type="submit" class="" id="todo_sub">
                                        {{ __('Completed') }}
                                    </x-primary-button>
                                </div>
                            </div>`);
                        });
                    }
                });
            }
            display();




            /* This is all Edit button functionality*/
            $(document).on("click", ".edtbtn", function(e) {
                e.preventDefault();
                var new_id = $(this).val();
                console.log(new_id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "{{ route('update_data') }}",
                    data: {
                        id: new_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        var list3 = response.new_values;
                        $("#cncl-edt").remove();
                        $.each(list3, function(ind, val) {
                            console.log(val.task_name);
                            $(".t_name").val(val.task_name);
                            $(".descr").val(val.task_desc);
                            $("#todo_sub").html("update");
                            $(".main-btn-div").append(`<x-primary-button type="submit" class="bg-red-800" id="cncl-edt">
                                {{ __('Undo Edit') }}
                            </x-primary-button>`);

                        });
                    }
                });

            });


            /*Undo button functionality Ends Here*/
            $(document).on("click", "#cncl-edt", function(e) {
                e.preventDefault();
                console.log("clicked");
                $("#todo_sub").html("submit todo");
                $(".t_name").val("");
                $(".descr").val("");
                $(".error").html("");
                $("#cncl-edt").remove();
            });
            /*Edit button functionality Ends Here*/

            

        });
    </script>

</x-app-layout>
