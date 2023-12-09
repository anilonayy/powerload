<template>
  <div>
    <div
      class="mobile-menu w-full flex lg:hidden justify-between px-4 border-b py-2 fixed top-0 bg-white z-20"
    >
      <SiteLogo />

      <ButtonCmp @click="updateAsideOpen(true)">
        <HamburgerIcon />
      </ButtonCmp>
    </div>

    <div
      class="lg:flex w-full lg:w-72 shrink-0 border-r border-gray-300 flex-col p-4 fixed bg-white overflow-y-scroll md:overflow-auto z-30"
      style="height: 100vh"
      :class="{ hidden: !isAsideOpen }"
    >
      <div
        class="close-button ms-auto w-full flex justify-end mb-4 md:hidden"
        @click="updateAsideOpen(false)"
      >
        <CloseIcon />
      </div>

      <div id="aside-logo" class="flex justify-center">
        <SiteLogo />
      </div>

      <div id="menu" class="mt-10 flex flex-col gap-3 mb-40">
        <BadgeLink :to="{ name: 'home' }" class="bg-gray-100 hover:bg-gray-200 text-sm">
          <HomeIcon />
          Ana Sayfa
        </BadgeLink>
        <BadgeLink :to="{ name: 'about' }" class="bg-gray-100 hover:bg-gray-200 text-sm">
          <LightningIcon />
          Hakkımızda
        </BadgeLink>

        <div v-if="isAuthenticated" class="flex flex-col gap-3">
          <BadgeLink :to="{ name: 'dashboard' }">
            <ActivityIcon />
            Genel Bakış
          </BadgeLink>

          <BadgeLink :to="{ name: 'trainings' }">
            <HeadphoneIcon />
            Antrenmanlar
          </BadgeLink>

          <BadgeLink :to="{ name: 'reset-password' }">
            <KeyIcon />
            Şifre Yenile
          </BadgeLink>

          <BadgeLink :to="{ name: 'profile' }">
            <UserSettingIcon />
            Profil Ayarları
          </BadgeLink>
        </div>
        <div v-else>
          <span class="text-xs text-center block"
            >Daha fazla sayfa için
            <router-link :to="{ name: 'login' }" class="underline"> giriş yapın! </router-link>
          </span>
        </div>
      </div>

      <div
        class="bg-white w-full bottom-4 mt-auto"
        style="width: 90%"
        :class="{ fixed: isAsideOpen, relative: !isAsideOpen }"
      >
        <div class="aside-bottom mt-auto bottom-4 w-full">
          <div v-if="isAuthenticated">
            <button
              @click="isOpen = !isOpen"
              id="dropdown-button"
              dropdown-close="true"
              class="inline-flex justify-start items-center w-full px-2 py-2 text-sm font-semibold bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
            >
              <UserIcon />

              <div
                class="flex flex-col justify-start items-start text-xs w-40 whitespace-nowrap"
                dropdown-close="true"
              >
                <div dropdown-close="true" class="text-gray-500">Hesabım</div>
                <div
                  dropdown-close="true"
                  class="overflow-ellipsis overflow-hidden w-full text-start"
                >
                  {{ userData.firstName }}
                </div>
              </div>

              <div class="ms-auto">
                <AngleDownIcon />
              </div>
            </button>
            <div
              v-if="isOpen"
              id="dropdown-menu"
              dropdown-area
              class="origin-top-right absolute mt-2 w-full left-0 bottom-full mb-4 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
            >
              <div
                class="py-2 p-2"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="dropdown-button"
              >
                <BadgeLink :to="{ name: 'home' }" @click="logout()">
                  <PowerIcon />
                  Çıkış Yap
                </BadgeLink>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="aside-bottom mt-auto text-center">
              <router-link :to="{ name: 'login' }" class="block font-semibold underline">
                Giriş Yap
              </router-link>

              <span class="text-sm block py-2">veya</span>

              <BadgeLink
                :to="{ name: 'register' }"
                class="bg-gray-100 hover:bg-gray-200 text-sm justify-center font-bold"
              >
                Kayıt Ol
              </BadgeLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SiteLogo from '@/Components/Shared/SiteLogo.vue'
import BadgeLink from '@/Components/Shared/BadgeLink.vue'

import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import CloseIcon from '@/Components/Icons/CloseIcon.vue'
import HomeIcon from '@/Components/Icons/HomeIcon.vue'
import HamburgerIcon from '@/Components/Icons/HamburgerIcon.vue'
import LightningIcon from '@/Components/Icons/LightningIcon.vue'
import ActivityIcon from '@/Components/Icons/ActivityIcon.vue'
import HeadphoneIcon from '@/Components/Icons/HeadphoneIcon.vue'
import KeyIcon from '@/Components/Icons/KeyIcon.vue'
import UserSettingIcon from '@/Components/Icons/UserSettingIcon.vue'
import UserIcon from '@/Components/Icons/UserIcon.vue'
import PowerIcon from '@/Components/Icons/PowerIcon.vue'
import AngleDownIcon from '@/Components/Icons/AngleDownIcon.vue'

import { computed, ref, inject, watchEffect } from 'vue'
import { useStore } from 'vuex'

const axios = inject('axios')
const store = useStore()

const isAuthenticated = computed(() => store.getters['_isAuthenticated'])
const currentUser = computed(() => store.getters['_getCurrentUser'])
const isAsideOpen = computed(() => store.getters['_getAsideOpen'])

const userData = ref({
  firstName: currentUser.value?.name?.split(' ')[0],
  email: currentUser.value?.email
})

const isOpen = ref(false)

const logout = async () => {
  try {
    await axios.post('/logout')
    await store.dispatch('logout')
  } catch (error) {
    console.log('Error Occured Logout Action =>', error.message)
  }
}

document.addEventListener('click', (event) => {
  const isCloseButton = event.target.getAttribute('dropdown-close')

  if (!isCloseButton) {
    isOpen.value = false
  }
})

watchEffect(() => {
  userData.value = {
    firstName: currentUser.value?.name,
    email: currentUser.value?.email
  }
})

const updateAsideOpen = (value) => {
  store.dispatch('updateAsideOpen', value)
}
</script>

<style lang="css">
.router-link-active.badge-item {
  background-color: rgba(219, 234, 254);
}
</style>
