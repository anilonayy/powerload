<template>
    <footer class="mt-auto border-t-2 py-6">
        <LayoutContainer>
            <div class="grid grid-cols-1 md:grid-cols-4 p-3 gap-5">
                <div class="flex justify-center md:justify-start">
                    <SiteLogo />
                </div>
                <div>
                    <ul class="flex flex-col gap-1">
                        <h4 class="font-bold text-xl underline-offset-2 underline mb-3">Menü</h4>
                        <li>
                            <a href="#">Ana Sayfa</a>
                        </li>
                        <li>
                            <a href="#">Hakkımızda</a>
                        </li>
                        <li>
                            <a href="#">İstek Yap</a>
                        </li>
                        <li>
                            <a href="#">İletişim</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="flex flex-col gap-1">
                        <h4 class="font-bold text-xl underline-offset-2 underline mb-3">Bloglar</h4>
                        <li>
                            <a href="#">Uygulamayı en verimli nasıl kullanırım?</a>
                        </li>
                        <li>
                            <a href="#">Antrenman programı nasıl olmalı?</a>
                        </li>
                        <li>
                            <a href="#">Besin önerileri</a>
                        </li>
                        <li>
                            <a href="#">Supplement tavsiyeleri</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="flex flex-col gap-1">
                        <h4 class="font-bold text-xl underline-offset-2 underline mb-3">Uygulamaları İndir</h4>
                        <li>
                            <a href="#">
                                <img src="/images/app-store.png" class="download-app" width="300">
                                </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/images/google-play.png" class="download-app" width="300">
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </LayoutContainer>
    </footer>
</template>

<script setup>
import LayoutContainer from '@/Components/Shared/LayoutContainer.vue'
import SiteLogo from '@/Components/Shared/SiteLogo.vue';
</script>

<style lang="scss" scoped></style>