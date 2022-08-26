<template>
    <div class="fixed flex justify-center lg:items-center bg-overlay overflow-auto z-[999] top-0 left-0 w-full h-full">
        <div class="bg-white rounded px-4 py-4 flex lg:item-start items-center w-full h-full lg:h-auto lg:w-[30rem]">
            <div class="flex-grow">
               <slot></slot>
            </div>
        </div>
     </div>
</template>

<script>
export default {
    name:"Modal Components"
}
</script>