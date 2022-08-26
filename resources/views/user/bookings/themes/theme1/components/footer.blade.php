<footer>
    <section class="bg-gray-800 text-gray-400">
        <div class="grid grid-cols-1 gap-4 place-items-center">
            <ul class="flex space-x-4 pt-10" >
                <li><a href="#" id="footerHomeBtn" >Home</a></li>
                <li><a href="#">Service</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <div class="text-center text-sm pb-10" >
                {{ $data->business_name }} &#169; {{ date('Y') }} Tryba. All Rights Reserved.
            </div>           
        </div>
    </section>
</footer>