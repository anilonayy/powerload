<template>
  <div class="h-full flex flex-col gap-5">
    <div class="w-full h-full mx-auto mt-0 rounded-md flex flex-col gap-8 md:flex-row items-center p-3">
      <div class="w-full mb-6 md:w-3/5 md:mb-0">
        <HeaderText class="text-[1.75rem] font-extrabold leading-9 tracking-tight text-slate-900 md:text-4xl mt-0">
          <div>
            <p
              v-html="$t('HOME.HEADER.TOP_TITLE')"
              class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-teal-900 uppercase rounded-full bg-teal-accent-400"
            />
          </div>

          <div v-html="$t('HOME.HEADER.TITLE')" />
        </HeaderText>
        <p class="mt-3" v-html="$t('HOME.HEADER.DESCRIPTION_TEXT_1')" />
        <p class="mt-3" v-html="$t('HOME.HEADER.DESCRIPTION_TEXT_2')" />
      </div>
      <div class="w-full md:w-2/5">
        <img src="/images/milo-of-croton.jpg" />
      </div>
    </div>

    <div class="py-4 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl lg:py-10">
      <div class="relative grid gap-8 row-gap-5 mb-8 md:row-gap-8 lg:grid-cols-4 sm:grid-cols-2">
        <div class="absolute inset-0 flex items-center justify-center sm:hidden lg:flex">
          <div class="w-px h-full bg-gray-300 lg:w-full lg:h-px"></div>
        </div>

        <div v-for="step in 4" :key="step">
          <div class="p-5 duration-300 transform bg-white border rounded shadow-sm hover:-translate-y-2 h-full">
            <div class="flex items-center justify-between mb-2">
              <p class="text-lg font-bold leading-5">{{ $t(`HOME.STEPS.${step}.TITLE`) }}</p>
              <p
                class="flex items-center justify-center w-6 h-6 font-bold rounded text-deep-purple-accent-400 bg-indigo-50"
              >
                {{ step }}
              </p>
            </div>
            <p class="text-sm text-gray-900">
              {{ $t(`HOME.STEPS.${step}.DESCRIPTION`) }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <h2 class="text-xl font-semibold">{{ $t('HOME.DOWNLOAD_TEXT') }}</h2>
    <div class="flex w-100 mt-4">
      <a href="#">
        <img src="/images/Google-Play-download-button.svg" class="w-72" alt="Google Play" />
      </a>
      <a href="#">
        <img src="/images/App-Store-download-button.svg" class="w-64" alt="App Store" />
      </a>
    </div>
  </div>
</template>

<script setup>
import HeaderText from '@/components/shared/HeaderText.vue';
</script>
