<template>
  <div>
    <HeaderText class="text-center"> Üye Ol </HeaderText>
    <Panel class="max-w-lg w-full my-8 p-8">
      <form @submit="formSubmit($event)" class="flex flex-col gap-4">
        <div>
          <Label for="name" value="Ad Soyad" />

          <Input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="userData.name"
            autofocus
            autocomplete="name"
          />

          <div v-if="errors?.name && errors?.name?.length > 0">
            <InputError class="mt-2" :message="errors.name[0]" />
          </div>
        </div>

        <div>
          <Label for="email" value="E-Posta" />

          <Input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="userData.email"
            autocomplete="username"
          />

          <div v-if="errors?.email && errors?.email?.length > 0">
            <InputError class="mt-2" :message="errors.email[0]" />
          </div>
        </div>

        <div>
          <Label for="password" value="Şifre" />

          <Input
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="userData.password"
            autocomplete="current-password"
          />

          <div v-if="errors?.password && errors?.password.length > 0">
            <InputError class="mt-2" :message="errors.password[0]" />
          </div>
        </div>

        <div>
          <Label for="password_confirm" value="Şifre Onay" />

          <Input
            id="password_confirm"
            type="password"
            class="mt-1 block w-full"
            v-model="userData.password_confirm"
          />

          <div v-if="errors?.password_confirm && errors?.password_confirm.length > 0">
            <InputError class="mt-2" :message="errors.password_confirm[0]" />
          </div>
        </div>

        <div v-if="errors?.message && errors?.message?.length" class="text-red-500 font-semibold my-4">
          {{ errors?.message }}
        </div>

        <button type="submit" class="dark-gray-btn"> Üye Ol </button>
        
        <hr class="my-6 border-gray-300 w-full" />

        
        <div class="btn border border-1">
            <GoogleIcon />
            <span class="ml-4">Google ile üye ol</span>
        </div>

        <div class="mt-6 font-">
          Zaten üye misin?
          <router-link to="/giris-yap" class="font-semibold text-blue-400">Giriş Yap</router-link>
        </div>
      </form>
    </Panel>
  </div>
</template>

<script setup>
import { ref, inject, watch } from 'vue';
import authService from '@/services/authService';
import router from '@/router'

import Panel from '@/components/shared/Panel.vue'
import Input from '@/components/form/Input.vue'
import Label from '@/components/form/Label.vue'
import InputError from '@/components/form/InputError.vue'
import HeaderText from '@/components/shared/HeaderText.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'

const toast = inject('toast');

const userData = ref({
  name: '',
  email: '',
  password: '',
  password_confirm: ''
})

const errors = ref({})

const formSubmit = async (event) => {
  event.preventDefault()

  try {
    if(!validateForm()) return;

    await authService.register(userData.value);

    Object.keys(userData.value).forEach((field) => (userData.value[field] = null));

    toast.success('Başarıyla kayıt oldun!');

    router.push('/');
  } catch (error) {
    errors.value = error.data;
  }
}

const validateForm = () => {
  errors.value.name = isEmpty(userData.value.name) ? ["Ad Soyad alanı zorunludur."] : [];
  errors.value.email = isEmpty(userData.value.email) ? ["E-Mail alanı zorunludur."] : [];
  errors.value.password = isEmpty(userData.value.password) ? ["Şifre alanı zorunludur."] : [];

  if (isEmpty(userData.value.password_confirm)) {
    errors.value.password_confirm = ["Şifre Onay alanı zorunludur."];
  } else if (userData.value.password !== userData.value.password_confirm) {
    errors.value.password_confirm = ["Şifreler eşleşmiyor."];
  } else {
    errors.value.password_confirm = [];
  }

  if(errors.value.message?.length) {
    errors.value.message = ''
  }

  return Object.keys(errors.value).every((field) => errors.value[field].length === 0)
}

const isEmpty = (field) => (field ?? '').trim().length === 0;

watch(userData.value, validateForm)
</script>

