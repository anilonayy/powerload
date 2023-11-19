<template>
    <header class="w-full flex justify-center border-b-2">
            <LayoutContainer>
                <div id="header-wrapper" class="flex items-center justify-between py-2 gap-5">
                <SiteLogo />
                <div class="menu md:block hidden">
                    <ul class="flex justify-center items-center gap-5 font-semibold">
                        <font-awesome-icon icon="fa-solid fa-user-secret" />
                        <menu-link to="/">Ana Sayfa</menu-link>
                        <menu-link to="/hakkimizda">Hakkımızda</menu-link>
                        <menu-link to="/istek-yap">İstek Yap</menu-link>
                        <menu-link to="/iletisim">İletişim</menu-link>
                    </ul>
                </div>

                <div v-if="isAuthenticated">
                    <div class="relative inline-block ">
                        <!-- Dropdown toggle button -->
                        <button @click="isOpen = !isOpen" class="relative z-10 flex items-center p-2 text-sm text-gray-600 bg-white border border-transparent rounded-md focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:text-white dark:bg-gray-800 focus:outline-none">
                            <span class="mx-1">Jane Doe</span>
                            <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 15.713L18.01 9.70299L16.597 8.28799L12 12.888L7.40399 8.28799L5.98999 9.70199L12 15.713Z" fill="currentColor"></path>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div v-show="isOpen" 
                            @click.away="isOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            class="absolute right-0 z-20 w-56 py-2 mt-2 overflow-hidden origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800"
                        >
                            <a href="#" class="flex items-center p-3 -mt-2 text-sm text-gray-600 transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                <img class="flex-shrink-0 object-cover mx-1 rounded-full w-9 h-9" src="https://images.unsplash.com/photo-1523779917675-b6ed3a42a561?ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8d29tYW4lMjBibHVlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=face&w=500&q=200" alt="jane avatar">
                                <div class="mx-1">
                                    <h1 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Jane Doe</h1>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">janedoe@exampl.com</p>
                                </div>
                            </a>

                            <hr class="border-gray-200 dark:border-gray-700 ">

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                view profile
                            </a>

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Settings
                            </a>

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Keyboard shortcuts
                            </a>

                            <hr class="border-gray-200 dark:border-gray-700 ">

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Company profile
                            </a>

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Team
                            </a>

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Invite colleagues
                            </a>

                            <hr class="border-gray-200 dark:border-gray-700 ">

                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Help
                            </a>
                            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
                <div v-else class="actions flex gap-3">
                    <router-link  to="/giris-yap">
                    
                        <OutlineButton class="bg-gray-100 hover:bg-gray-200 text-black">
                            <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 me-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>

                            Giriş Yap
                            </OutlineButton>
                    </router-link>
                    <router-link  to="/uye-ol">
                        <ButtonCmp class="bg-gray-800 hover:bg-gray-600 text-white" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 me-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            Üye Ol
                        </ButtonCmp>
                    </router-link>
                   
                </div>
                
            </div>
            </LayoutContainer>
            
    </header>
</template>

<script setup>
    import SiteLogo from '@/Components/Shared/SiteLogo.vue'
    import MenuLink from '@/Components/Shared/MenuLink.vue';
    import ButtonCmp from "@/Components/buttons/ButtonCmp.vue";
    import OutlineButton from "@/Components/buttons/OutlineButton.vue";
    import LayoutContainer from "@/Components/Shared/LayoutContainer.vue";
    import { useStore } from 'vuex';
    import { computed, ref } from 'vue';

    const store =  useStore();
    const isAuthenticated = computed(() => store.getters['_isAuthenticated']);

    const isOpen = ref(false);

</script>

<style lang="scss" scoped>


</style>