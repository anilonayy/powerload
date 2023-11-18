<template>
    <header class="w-full flex justify-center border-b-2">
            <LayoutContainer>
                <div id="header-wrapper" class="flex items-center justify-between py-2 gap-5">
                <SiteLogo />
                <div class="menu md:block hidden">
                    <ul class="flex justify-center items-center gap-5 font-semibold">
                        <MenuLink to="/">Ana Sayfa</MenuLink>
                        <MenuLink to="/hakkimizda">Hakkımızda</MenuLink>
                        <MenuLink to="/istek-yap">İstek Yap</MenuLink>
                        <MenuLink to="/iletisim">İletişim</MenuLink>
                    </ul>
                </div>
                <div class="actions flex gap-3">
                    <router-link  to="/login">
                        <OutlineButton bg="white-300" text="black">Giriş Yap</OutlineButton>
                    </router-link>
                    <router-link  to="/login">
                        <ButtonCmp bg="gray-700" text="white" >Üye Ol</ButtonCmp>
                    </router-link>
                   
                </div>
                
            </div>
            </LayoutContainer>
            
    </header>
</template>

<script setup>
    import SiteLogo from '@/components/SiteLogo.vue'
    import MenuLink from '@/components/menu/MenuLink.vue';
    import ButtonCmp from "@/components/buttons/ButtonCmp.vue";
    import OutlineButton from "@/components/buttons/OutlineButton.vue";
    import LayoutContainer from "@/components/layout/LayoutContainer.vue";
</script>

<style lang="scss" scoped>


</style>