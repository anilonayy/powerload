<template>
  <div class="w-72 shrink-0 border-r border-gray-300 flex flex-col p-4 h-full">
    <div id="aside-logo">
      <SiteLogo />
    </div>

    <div id="menu" class="mt-12 flex flex-col gap-3">
      <BadgeLink :to="{ name: 'home' }" class="bg-gray-100 hover:bg-gray-200 text-sm">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-6 h-6 mr-2 text-xs"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
          />
        </svg>
        Ana Sayfa
      </BadgeLink>
      <BadgeLink :to="{ name: 'about' }" class="bg-gray-100 hover:bg-gray-200 text-sm">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-6 h-6 mr-2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"
          />
        </svg>
        Hakkımızda
      </BadgeLink>

      <div v-if="isAuthenticated" class="flex flex-col gap-3">
        <BadgeLink :to="{ name: 'dashboard' }">
          <svg
            class="mr-2"
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <rect width="18" height="18" x="3" y="3" rx="2" />
            <path d="M17 12h-2l-2 5-2-10-2 5H7" />
          </svg>
          Genel Bakış
        </BadgeLink>

        <BadgeLink :to="{ name: 'trainings' }">
          <svg
            class="mr-2"
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path
              d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"
            />
          </svg>
          Antrenmanlar
        </BadgeLink>

        <BadgeLink :to="{ name: 'reset-password' }">
          <svg
            class="mr-2"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z" />
            <circle cx="16.5" cy="7.5" r=".5" />
          </svg>
          Şifre Yenile
        </BadgeLink>

        <BadgeLink :to="{ name: 'profile' }">
          <svg
            class="mr-2"
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M2 21a8 8 0 0 1 10.434-7.62" />
            <circle cx="10" cy="8" r="5" />
            <circle cx="18" cy="18" r="3" />
            <path d="m19.5 14.3-.4.9" />
            <path d="m16.9 20.8-.4.9" />
            <path d="m21.7 19.5-.9-.4" />
            <path d="m15.2 16.9-.9-.4" />
            <path d="m21.7 16.5-.9.4" />
            <path d="m15.2 19.1-.9.4" />
            <path d="m19.5 21.7-.4-.9" />
            <path d="m16.9 15.2-.4-.9" />
          </svg>
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

    <div class="aside-bottom mt-auto relative">
      <div v-if="isAuthenticated">
        <button
          @click="isOpen = !isOpen"
          id="dropdown-button"
          dropdown-close="true"
          class="inline-flex justify-start items-center w-full px-2 py-2 text-sm font-semibold bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            dropdown-close="true"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6 mr-3"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
            />
          </svg>

          <div class="flex flex-col justify-start items-start text-xs w-40 whitespace-nowrap" dropdown-close="true">
            <div  dropdown-close="true" class="text-gray-500" >Hesabım</div>
            <div  dropdown-close="true" class="overflow-ellipsis overflow-hidden w-full text-start">{{ userData.firstName }}</div>
          </div>

          <div class="ms-auto">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              dropdown-close="true"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-4 h-4 me-2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19.5 8.25l-7.5 7.5-7.5-7.5"
              />
            </svg>
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
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mr-2"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#000000"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                <line x1="12" y1="2" x2="12" y2="12"></line>
              </svg>
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
</template>

<script setup>
import SiteLogo from '@/Components/Shared/SiteLogo.vue'
import BadgeLink from '@/Components/Shared/BadgeLink.vue'

import { computed, ref, inject, watchEffect } from 'vue'
import { useStore } from 'vuex'

import MenuLink from '@/Components/Shared/MenuLink.vue'
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import OutlineButton from '@/Components/buttons/OutlineButton.vue'

const axios = inject('axios')
const store = useStore()
const isAuthenticated = computed(() => store.getters['_isAuthenticated'])
const currentUser = computed(() => store.getters['_getCurrentUser'])

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

  console.log('isCloseButton :>> ', isCloseButton)

  if (!isCloseButton) {
    isOpen.value = false
  }
})

watchEffect(() => {
  // Catch all user updates
  userData.value = {
    firstName: currentUser.value?.name,
    email: currentUser.value?.email
  }
})
</script>

<style lang="css">
.router-link-active.badge-item {
  background-color: rgba(219, 234, 254);
}
</style>