<template>
  <div>
    <HeaderText class="text-center">{{ $t('AUTH.REGISTER.TITLE') }}</HeaderText>
    <Panel class="max-w-lg w-full my-8 p-8">
      <form @submit="formSubmit($event)" class="flex flex-col gap-4">
        <div>
          <Label for="name" :value="$t('AUTH.REGISTER.FORM.NAME')" />

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
          <Label for="email" :value="$t('AUTH.REGISTER.FORM.EMAIL')" />

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
          <Label for="password" :value="$t('AUTH.REGISTER.FORM.PASSWORD')" />

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
          <Label for="password_confirm" :value="$t('AUTH.REGISTER.FORM.PASSWORD_CONFIRMATION')" />

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

        <button type="submit" class="dark-gray-btn"> {{ $t('AUTH.REGISTER.FORM.SUBMIT') }} </button>
        
        <hr class="my-6 border-gray-300 w-full" />

        
        <div class="btn border border-1">
            <GoogleIcon />
            <span class="ml-4">{{ $t('AUTH.REGISTER.FORM.REGISTER_GOOGLE') }}</span>
        </div>

        <div class="mt-6 font-">
          {{ $t('AUTH.REGISTER.FORM.ALREADY_REGISTERED') }}
          <router-link to="/giris-yap" class="font-semibold text-blue-400">{{ $t('AUTH.REGISTER.FORM.LOGIN') }}</router-link>
        </div>
      </form>
    </Panel>
  </div>
</template>

<script setup>
import { ref, inject, watch } from 'vue';
import authService from '@/services/authService';
import router from '@/router'
import { useI18n } from 'vue-i18n';

import Panel from '@/components/shared/Panel.vue'
import Input from '@/components/form/Input.vue'
import Label from '@/components/form/Label.vue'
import InputError from '@/components/form/InputError.vue'
import HeaderText from '@/components/shared/HeaderText.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'

const toast = inject('toast');
const { t } = useI18n();

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

    toast.success('Başarıyla kayıt oldun!');

    router.push('/');
  } catch (error) {
    errors.value = error.data;
  }
}

const validateForm = () => {
  errors.value.name = isEmpty(userData.value.name) ? [t('AUTH.REGISTER.FORM.NAME_EMPTY_ERROR')] : [];
  errors.value.email = isEmpty(userData.value.email) ? [t('AUTH.REGISTER.FORM.EMAIL_EMPTY_ERROR')] : [];
  errors.value.password = isEmpty(userData.value.password) ? [t('AUTH.REGISTER.FORM.PASSWORD_EMPTY_ERROR')] : [];

  if (isEmpty(userData.value.password_confirm)) {
    errors.value.password_confirm = [t('AUTH.REGISTER.FORM.PASSWORD_CONFIRMATION_EMPTY_ERROR')];
  } else if (userData.value.password !== userData.value.password_confirm) {
    errors.value.password_confirm = [t('AUTH.REGISTER.FORM.PASSWORD_CONFIRMATION_MATCH_ERROR')];
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

