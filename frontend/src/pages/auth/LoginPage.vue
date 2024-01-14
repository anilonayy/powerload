<template>
  <div>
    <HeaderText class="text-center"> Giriş Yap </HeaderText>
    <Panel class="max-w-lg w-full my-16 p-8">
      <form @submit="formSubmit($event)">
        <div>
          <Label for="email" value="E-Posta" />

          <Input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="userData.email"
            autocomplete="email "
          />

          <div v-if="errors?.email && errors?.email?.length > 0">
            <InputError class="mt-2" :message="errors?.email[0]" />
          </div>
        </div>

        <div class="mt-4">
          <Label for="password" value="Şifre" />

          <Input
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="userData.password"
            autocomplete="current-password"
          />

          <div v-if="errors?.password && errors?.password?.length > 0">
            <InputError class="mt-2" :message="errors?.password[0]" />
          </div>

          <div class="flex w-full justify-end">
            <router-link to="/sifremi-unuttum" class="text-sm underline underline-offset-1"
              >Şifremi Unuttum</router-link
            >
          </div>
        </div>

        <div v-if="errors?.message && errors?.message?.length" class="text-red-500 font-semibold my-4">
          {{ errors?.message }}
        </div>

        <button type="submit" class="dark-gray-btn w-full mt-4"> Giriş Yap </button>

        <hr class="my-6 border-gray-300 w-full" />

        <div class="btn border border-1 w-full">
            <GoogleIcon />
            <span class="ml-4">Google ile giriş yap</span>
        </div>
        

        <div class="mt-6 font-">
          Üyeliğin yok mu?
          <router-link to="/uye-ol" class="font-semibold text-blue-400">Üye Ol</router-link>
        </div>
      </form>
    </Panel>
  </div>
</template>

<script setup>
import { ref, inject, watch } from 'vue'
import router from '@/router'
import authService from '@/services/authService'

import Panel from '@/components/shared/Panel.vue'
import Input from '@/components/form/Input.vue'
import InputError from '@/components/form/InputError.vue'
import Label from '@/components/form/Label.vue'
import HeaderText from '@/components/shared/HeaderText.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'

const toast = inject('toast')

const userData = ref({
  email: '',
  password: '',
});

const errors = ref({
  email: [],
  password: [],
  message: ''
})

const formSubmit = async (event) => {
  event.preventDefault()

  try {
    if(validateForm()) {
      await authService.login(userData.value);

      Object.keys(userData.value).forEach((field) => (userData.value[field] = null)) // Remove all values

      router.push({ name: 'dashboard' });
    }
  } catch (error) {
    errors.value = error.data ?? {};

    !errors.value?.message && toast.error(error?.message);
  }
}

const validateForm = () => {
  errors.value.email = isEmpty(userData?.value?.email) ? ["E-Mail alanı zorunludur."] : [];
  errors.value.password = isEmpty(userData?.value?.password) ? ["Şifre alanı zorunludur."] : [];

  if(errors.value.message?.length) {
    errors.value.message = ''
  }

  return Object.keys(errors.value).every((field) => errors.value[field].length === 0)
}

const isEmpty = (field) => (field ?? '').trim().length === 0;

watch(userData.value, validateForm)
</script>
