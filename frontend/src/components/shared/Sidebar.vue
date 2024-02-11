<template>
  <div>
    <div
      class="mobile-menu w-full flex md:hidden justify-between px-4 border-b py-2 fixed top-0 bg-white z-20 landscape:hidden"
    >
      <SiteLogo />

      <div class="btn border border-1" @click="updateAsideOpen(true)">
        <HamburgerIcon />
      </div>
    </div>

    <div
      class="md:flex w-full md:w-72 shrink-0 border-r border-gray-300 flex-col p-4 fixed bg-white overflow-y-scroll md:overflow-auto z-30"
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
          {{ $t('SIDEBAR.MENU.HOME') }}
        </BadgeLink>
        <BadgeLink :to="{ name: 'about' }" class="bg-gray-100 hover:bg-gray-200 text-sm">
          <LightningIcon />
          {{ $t('SIDEBAR.MENU.ABOUT') }}
        </BadgeLink>

        <div v-if="isAuthenticated" class="flex flex-col gap-3">
          <BadgeLink :to="{ name: 'dashboard' }">
            <ActivityIcon />
            {{ $t('SIDEBAR.MENU.DASHBOARD') }}
          </BadgeLink>

          <BadgeLink :to="{ name: 'workout-list' }">
            <ListIcon />
            {{ $t('SIDEBAR.MENU.WORKOUT_LIST') }}
          </BadgeLink>

          <BadgeLink :to="{ name: 'workout-history' }">
            <HeadphoneIcon />
            {{ $t('SIDEBAR.MENU.WORKOUT_HISTORY') }}
          </BadgeLink>

          <BadgeLink :to="{ name: 'reset-password' }">
            <KeyIcon />
            {{ $t('SIDEBAR.MENU.RESET_PASSWORD') }}
          </BadgeLink>

          <BadgeLink :to="{ name: 'profile' }">
            <UserSettingIcon />
            {{ $t('SIDEBAR.MENU.PROFILE_SETTINGS') }}
          </BadgeLink>
        </div>
        <div v-else>
          <span class="text-xs text-center block"
            >
            {{ $t('SIDEBAR.AUTH.FOR_MORE_INFO') }}
            <router-link :to="{ name: 'login' }" class="underline"> {{ $t('SIDEBAR.AUTH.GO_LOGIN') }} </router-link>
          </span>
        </div>
      </div>
      
  
      <div
        class="bg-white w-full bottom-4 mt-auto"
        style="width: 90%"
        :class="{ fixed: isAsideOpen, relative: !isAsideOpen }"
      >
        
        <SelectLanguage />

        <div class="aside-bottom mt-auto bottom-4 w-full">
          <div v-if="isAuthenticated" class="relative">
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
                <div dropdown-close="true" class="text-gray-500">{{ $t('SIDEBAR.AUTH.MY_ACCOUNT') }}</div>
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
                  {{ $t('SIDEBAR.AUTH.LOGOUT') }}
                </BadgeLink>
              </div>
            </div>
          </div>
          <div v-else>
            <div class="aside-bottom mt-auto text-center">
              <router-link :to="{ name: 'login' }" class="block font-semibold underline">
                {{ $t('SIDEBAR.AUTH.LOGIN') }}
              </router-link>

              <span class="text-sm block py-2">{{ $t('SIDEBAR.AUTH.OR') }}</span>

              <BadgeLink
                :to="{ name: 'register' }"
                class="bg-gray-100 hover:bg-gray-200 text-sm justify-center font-bold"
              >
                {{ $t('SIDEBAR.AUTH.REGISTER') }}
              </BadgeLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SiteLogo from '@/components/shared/SiteLogo.vue';
import BadgeLink from '@/components/shared/BadgeLink.vue';
import CloseIcon from '@/components/icons/CloseIcon.vue';
import HomeIcon from '@/components/icons/HomeIcon.vue';
import HamburgerIcon from '@/components/icons/HamburgerIcon.vue';
import LightningIcon from '@/components/icons/LightningIcon.vue';
import ActivityIcon from '@/components/icons/ActivityIcon.vue';
import HeadphoneIcon from '@/components/icons/HeadphoneIcon.vue';
import KeyIcon from '@/components/icons/KeyIcon.vue';
import UserSettingIcon from '@/components/icons/UserSettingIcon.vue';
import UserIcon from '@/components/icons/UserIcon.vue';
import PowerIcon from '@/components/icons/PowerIcon.vue';
import AngleDownIcon from '@/components/icons/AngleDownIcon.vue';
import ListIcon from '@/components/icons/ListIcon.vue';
import SelectLanguage from '@/components/sidebar/SelectLanguage.vue';

import {computed, ref, watchEffect} from 'vue'
import {useStore} from 'vuex';
import authService from '@/services/authService';


const store = useStore();

const isAuthenticated = computed(() => store.getters['_isAuthenticated'])
const currentUser = computed(() => store.getters['_currentUser'])
const isAsideOpen = computed(() => store.getters['_isAsideOpen'])

const userData = ref({
  firstName: currentUser.value?.name?.split(' ')[0],
  email: currentUser.value?.email
})

const isOpen = ref(false)

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

const logout = async () => {
  await authService.logout();
}
</script>

<style lang="css">
.router-link-active.badge-item {
  background-color: rgba(219, 234, 254);
}
</style>
