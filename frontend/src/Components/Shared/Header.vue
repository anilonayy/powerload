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
                    <div class="bg-gray-100  flex items-center justify-center">
                        <div class="relative inline-block text-left">
                            <button  @click="isOpen = !isOpen" id="dropdown-button" dropdown-area class="inline-flex justify-center w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                {{ userData.firstName }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-if="isOpen" id="dropdown-menu" dropdown-area class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-2 p-2" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button">
                                    
                                    <BadgeLink :to="{ name: 'dashboard' }"> 
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M17 12h-2l-2 5-2-10-2 5H7"/></svg>
                                        Gym Side
                                    </BadgeLink>

                                    <BadgeLink :to="{ name: 'profile' }"> 
                                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        Profilim
                                    </BadgeLink> 

                                    <BadgeLink :to="{ name: 'home' }" @click="logout()"  > 
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>                                
                                        Çıkış Yap
                                    </BadgeLink> 
                                </div>
                            </div>
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
    import { computed, ref } from 'vue';
    import { useStore } from 'vuex';
    import axios from '@/Utils/axios';
    import SiteLogo from '@/Components/Shared/SiteLogo.vue'
    import MenuLink from '@/Components/Shared/MenuLink.vue';
    import ButtonCmp from "@/Components/buttons/ButtonCmp.vue";
    import OutlineButton from "@/Components/buttons/OutlineButton.vue";
    import LayoutContainer from "@/Components/Shared/LayoutContainer.vue";
    import BadgeLink from '@/Components/Shared/BadgeLink.vue';

    const store =  useStore();
    const isAuthenticated = computed(() => store.getters['_isAuthenticated']);
    const currentUser = computed(() => store.getters['_getCurrentUser']);

    const userData = ref({
        firstName: currentUser?.value?.name?.split(' ')[0],
        email: currentUser?.value?.email
    });

    const isOpen = ref(false);

    const logout = async () => {

        try {
            await axios.post('/logout');
            await store.dispatch('logout');

            localStorage.removeItem('_token');
        } catch (error) {
            console.log('Error Occured Logout Action =>', error.response.data.message);
        }
    }

    document.addEventListener('click',(event) => {
        if (!(event.target.id === 'dropdown-button' || event.target.id === 'dropdown-menu')) {
            isOpen.value = false;
        }
    })
</script>
