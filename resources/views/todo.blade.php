<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todo List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" id="form_div">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Create new list') }}
                    </h2>

                    <div class="error my-5"></div>
                    <div class="grid grid-cols-1 gap-5">

                        <div class="id_div" style="display:none;">
                            <x-input-label for="name" :value="__('Task Id')" />
                            <x-text-input id="t_id" class="block mt-1 w-full t_id" type="text" name="id"
                                :value="old('id')" required autofocus />
                        </div>

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
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200" id="crtd_list_div">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-5">
                            {{ __('Created lists') }}
                        </h2>

                        <div class="grid grid-cols-3 gap-5 crtd_list" id="crtd_list">


                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200" id="cmpltd_list_div">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-5">
                            {{ __('Completed lists') }}
                        </h2>

                        <div class="grid grid-cols-3 gap-5 cmpltd_list" id="cmpltd_list">


                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Todo Form Submission and updation begins here
            $("#todo_sub").click(function(e) {
                e.preventDefault();
                var t_name = "",
                    t_desc = "",
                    t_status = "0"
                t_id = "";
                t_name = $(".t_name").val();
                t_desc = $(".descr").val();
                t_id = $("#t_id").val();
                console.log(t_name, t_desc, t_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if (t_id == "" && t_name != "" && t_desc != "") {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('todo_insert') }}",
                        data: {
                            task_name: t_name,
                            task_desc: t_desc,
                            status: t_status
                        },
                        dataType: "JSON",
                        success: function(response) {
                            console.log(response);
                        }
                    });
                    $(".t_name").val("");
                    $(".descr").val("");
                    $(".error").html("Task Created Sucessfully");
                    $('html, body').animate({
                        scrollTop: $("#crtd_list_div").offset().top
                    }, 1000);

                    display();
                } else if (t_id != "" && t_name != "" && t_desc != "") {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('edt_todo') }}",
                        data: {
                            task_name: t_name,
                            task_desc: t_desc,
                            id: t_id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            console.log(response.msg);
                        }
                    });
                    $(".t_name").val("");
                    $(".descr").val("");
                    $(".error").html("Task Updated Sucessfully");
                    $("#cncl-edt").remove();
                    $("#todo_sub").html("submit todo");
                    $('html, body').animate({
                        scrollTop: $("#crtd_list_div").offset().top
                    }, 2000);

                    display();
                    completed_display();

                } else {
                    $(".error").html("Some fields are missing");
                }
            });
            //Todo Form Submission and updation ends here

            //Getting the values starts here
            function display() {
                $.ajax({
                    type: "get",
                    url: "{{ route('get_todo_data') }}",
                    data: {
                        status: "0"
                    },
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response.values);
                        var list2 = response.values;
                        $(".crtd_list").html("");
                        $.each(list2, function(ind, val) {
                            // console.log(ind, "noval");
                            $(".crtd_list").append(`<div class="max-w-sm rounded bg-red-400 overflow-hidden shadow-lg shadow-sm sm:rounded-lg ${"card" + val.id}" id="${"card" + val.id}">
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2" style="min-height:60px;">${val.task_name}</div>
                                    <p class="text-gray-700 text-base" style="min-height:50px;">
                                       ${val.task_desc}
                                    </p>

                                    
                                   
                                </div>
                                <p class="text-gray-700 text-base px-6 py-4" style="min-height:50px;">
                                       ${val.created}
                                    </p>
                                <div class="px-6 pt-4 pb-2">
                                    <x-primary-button type="submit" class="edtbtn" id="edtbtn" value="${val.id}">
                                        {{ __('Edit') }}
                                    </x-primary-button>

                                    <x-primary-button type="submit" class="completed_lists bg-blue-800" value="${val.id}" id="completed_list">
                                        {{ __('Completed') }}
                                    </x-primary-button>

                                  
                                    <x-primary-button type="button"  class="dltbtn bg-red-800" id="dltbtn" value="${val.id}">
                                        {{ __('delete') }}
                                    </x-primary-button>
                                   
                                </div>
                            </div>`);
                        });
                    }
                });
            }
            display();


            function completed_display() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('completed_todo_data') }}",
                    data: {
                        status: '1'
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        var list3 = response.completed_values;
                        $(".cmpltd_list").html("");
                        $.each(list3, function(ind, val) {
                            $(".cmpltd_list").append(`<div class="max-w-sm rounded bg-green-400 overflow-hidden shadow-lg shadow-sm sm:rounded-lg ${"card" + val.id}" id="${"card" + val.id}">
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2" style="min-height:60px;">${val.task_name}</div>
                                    <p class="text-gray-700 text-base" style="min-height:50px;">
                                       ${val.task_desc}
                                    </p>
                                   
                                </div>
                                <div class="px-6 pt-4 pb-2">
                                    <div class="grid grid-cols-2">
                                    
                                    <div>
                                    <x-primary-button type="button"  class="dltbtn" id="dltbtn" value="${val.id}">
                                        {{ __('delete') }}
                                    </x-primary-button>
                                    </div>

                                    <div>
                                    <p class="text-gray-700 text-base" style="min-height:50px;">
                                       ${val.created}
                                    </p>
                                    </div>
                                   
                                    </div>
                                    
                                </div>
                            </div>`);
                        });
                    }
                });
            }
            completed_display();
            //Getting the values ends here

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
                            $("#t_id").val(val.id);
                            $("#todo_sub").html("update");
                            $(".main-btn-div").append(`<x-primary-button type="submit" class="bg-red-800" id="cncl-edt">
                                {{ __('Undo Edit') }}
                            </x-primary-button>`);
                            $('html, body').animate({
                                scrollTop: $("#form_div").offset().top
                            }, 2000);

                        });
                    }
                });

            });


            /*Undo button functionality Ends Here*/
            $(document).on("click", "#cncl-edt", function(e) {
                e.preventDefault();
                $("#todo_sub").html("submit todo");
                $(".t_name").val("");
                $(".descr").val("");
                $(".error").html("");
                $("#cncl-edt").remove();
            });

            /*Edit button functionality Ends Here*/

            //This will move the list to completed state 
            $(document).on("click", "#completed_list", function(e) {
                e.preventDefault();
                var cmplt_id = $(this).val();
                console.log("clicked", cmplt_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "post",
                    url: "{{ route('chng_cmpltd') }}",
                    data: {
                        status: "1",
                        id: cmplt_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response.msg);
                        $('html, body').animate({
                            scrollTop: $("#cmpltd_list_div").offset().top
                        }, 2000);

                    }
                });
                display();
                completed_display();
            });
            //above moving to completed ends here

            $(document).on("click", "#dltbtn", function() {
                // e.preventDefault();
                var a = $(this).val();
                console.log(a);

                var retVal = confirm("are you sure?");
                if (retVal == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "delete",
                        url: "{{ route('dlt_todo') }}",
                        data: {
                            id: a
                        },
                        dataType: "JSON",
                        success: function(response) {
                            display();
                            completed_display();
                        }
                    });
                    return true;
                }


            });
        });
    </script>

</x-app-layout>
