<section>
    <div class="container mx-auto p-16 " >
        <div class="h-52 rounded-lg">
            <h1 class="font-semibold text-4xl">{{_("Book our service")}}</h1>
            <form action="" method="post">
                <div class="grid grid-cols-5 my-8 gap-4" >
                    <div>
                        <label for="name" class="text-sm block">{{ ("Select service")}}</label>
                        <select name="" id="" class="p-3 rounded-md mt-2 w-full bg-gray-200">
                            <option value="">{{ ("Select service")}}</option>
                            @foreach ($data->services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="name" class="text-sm block">{{ _("Quantity")}}</label>
                        <select name="" id="" class="p-3 rounded-md mt-2 w-full bg-gray-200">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="name" class="text-sm block">{{ _("Date")}}</label>
                        <input type="date" name="date" min="{{ date('Y-m-d'); }}" value="{{ date('Y-m-d'); }}" class="p-3 rounded-md mt-2 w-full bg-gray-200" placeholder="Select date">
                    </div>
                    <div>
                        <label for="name" class="text-sm block">{{ _("Time")}}</label>
                        <select name="" id="" class="p-3 rounded-md mt-2 w-full bg-gray-200">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex items-center" >
                        <button type="submit" class="brand p-3 w-full rounded-md text-gray-100 mt-7" >{{ _("Submit")}}</button>
                    </div>

                </div>
             
            </form>
        </div>
    </div>
</section>