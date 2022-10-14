<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="error"></div>
                    
                    <form action="{{route('insert_comp')}}" method="POST">
                    @csrf
                        <div class="grid grid-cols-2 gap-5">

                            <div>
                                <x-input-label for="email" :value="__('Company Name')" />
                                <x-text-input id="cname" class="block mt-1 w-full" type="text" name="name" :value="old('cname')" required autofocus />
                            </div>


                            <div>
                                <x-input-label for="email" :value="__('Company Mail')" />
                                <x-text-input id="cmail" class="block mt-1 w-full" type="email" name="email" :value="old('cmail')" required />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Company location')" />
                                <x-text-input id="clocation" class="block mt-1 w-full" type="text" name="location" :value="old('clocation')" required />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Contact number')" />
                                <x-text-input id="cphone" class="block mt-1 w-full" type="number" name="phone" :value="old('cphone')" required />
                            </div>
                            <div>
                                <x-primary-button type="submit" class="" id="com_sub">
                                    {{ __('Submit Company') }}
                                </x-primary-button>

                            </div>
<div>@foreach ($values as $name)
    {{$name}}
    @endforeach
</div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/jquery.js')}}"></script>
    <script>
        $(document).ready(function() {
            console.log('executed');

            // $("#com_sub").click(function(e) {
            //     e.preventDefault();
            //     var name, cmail, cphone, clocation;
            //     name = $("#cname").val();
            //     cmail = $("#cmail").val();
            //     cphone = $("#cphone").val();
            //     clocation = $("#clocation").val();
            //     if (name != '' && cmail != '' && cphone != '' && clocation != '') {
            //         console.log(name, cmail, clocation, cphone);
            //     } else {
            //         $("#error").append(` <div class="bg-green-600 my-3 px-5 py-2 rounded" id="error"> 
            //         <p class="font-bold">Not present</p>
            //       </div> `);
            //     }
            // });
        });
    </script>
</x-app-layout>