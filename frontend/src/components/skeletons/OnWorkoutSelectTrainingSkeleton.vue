<template>
    <div>
        <div class="flex flex-col gap-3 mt-8">
            <div v-for="(index) in 5" :key="index" >
                <div class="py-8 cursor-pointer  animate-pulse bg-gray-200 rounded-md dark:bg-gray-700 block h-8" > </div> 
            </div>
        </div>
    </div>
</template>