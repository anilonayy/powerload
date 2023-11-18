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
                <div class="actions flex gap-3">
                    <router-link  to="/giris-yap">
                    
                        <OutlineButton class="bg-gray-100 hover:bg-gray-200 text-black">
                            <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 me-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>

                            Giriş Yap
                            </OutlineButton>
                    </router-link>
                    <router-link  to="/uye-ol">
                        <ButtonCmp class="bg-gray-600 hover:bg-gray-800 text-white" >
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
    import SiteLogo from '@/Components/SiteLogo.vue'
    import MenuLink from '@/Components/UserLayout/MenuLink.vue';
    import ButtonCmp from "@/Components/buttons/ButtonCmp.vue";
    import OutlineButton from "@/Components/buttons/OutlineButton.vue";
    import LayoutContainer from "@/Components/LayoutContainer.vue";
</script>

<style lang="scss" scoped>


</style>