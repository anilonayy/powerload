<template>
  <div>
    <HeaderText class="text-center">{{ $t('AUTH.LOGIN.TITLE') }}</HeaderText>
    <Panel class="max-w-lg w-full my-16 p-8">
      <form @submit="formSubmit($event)">
        <div>
          <Label for="email" :value="$t('AUTH.LOGIN.FORM.EMAIL')" />

          <Input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="userData.email"
            autocomplete="email"
          />

          <div v-if="errors?.email && errors?.email?.length > 0">
            <InputError class="mt-2" :message="errors?.email[0]" />
          </div>
        </div>

        <div class="mt-4">
          <Label for="password" :value="$t('AUTH.LOGIN.FORM.PASSWORD')" />

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
            <router-link :to="{ name: 'forgot-password' }" class="text-sm underline underline-offset-1">
              {{ $t('AUTH.LOGIN.FORM.FORGET_PASSWORD') }}
            </router-link
            >
          </div>
        </div>

        <div v-if="errors?.message && errors?.message?.length" class="text-red-500 font-semibold my-4">
          {{ errors?.message }}
        </div>

        <button type="submit" class="dark-gray-btn w-full mt-4"> {{ $t('AUTH.LOGIN.FORM.SUBMIT') }} </button>

        <hr class="my-6 border-gray-300 w-full" />

        <div class="btn border border-1 w-full">
            <GoogleIcon />
            <span class="ml-4">{{ $t('AUTH.LOGIN.FORM.GOOGLE_LOGIN') }}</span>
        </div>
        

        <div class="mt-6 font-">
          {{ $t('AUTH.LOGIN.FORM.NO_ACCOUNT') }}
          <router-link :to="{ name: 'register' }" class="font-semibold text-blue-400">
          {{ $t('AUTH.LOGIN.FORM.REGISTER') }}
          </router-link>
        </div>
      </form>
    </Panel>
  </div>
</template>

<script setup>
import { ref, inject, watch } from 'vue'
import router from '@/router'
import authService from '@/services/authService'
import { useI18n } from 'vue-i18n';

import Panel from '@/components/shared/Panel.vue'
import Input from '@/components/form/Input.vue'
import InputError from '@/components/form/InputError.vue'
import Label from '@/components/form/Label.vue'
import HeaderText from '@/components/shared/HeaderText.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'

const toast = inject('toast');
const { t } = useI18n();

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

      router.push({ name: 'dashboard' });
    }
  } catch (error) {
    errors.value = error.data ?? {};

    !errors.value?.message && toast.error(error?.message);
  }
}

const validateForm = () => {
  errors.value.email = isEmpty(userData?.value?.email) ? [t('AUTH.LOGIN.FORM.EMAIL_EMPTY_ERROR')] : [];
  errors.value.password = isEmpty(userData?.value?.password) ? [t('AUTH.LOGIN.FORM.PASSWORD_EMPTY_ERROR')] : [];

  if(errors.value.message?.length) {
    errors.value.message = ''
  }

  return Object.keys(errors.value).every((field) => errors.value[field].length === 0)
}

const isEmpty = (field) => (field ?? '').trim().length === 0;

watch(userData.value, validateForm)
</script>
