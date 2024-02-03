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
            required
          />

          <ErrorList error-key="name" :errors="errors"  />
        </div>

        <div>
          <Label for="username" :value="$t('AUTH.REGISTER.FORM.EMAIL')" />

          <Input
            id="username"
            type="email"
            class="mt-1 block w-full"
            v-model="userData.email"
            autocomplete="username"
            required
          />

          <ErrorList error-key="email" :errors="errors"  />
        </div>

        <div>
          <Label for="birthday" :value="$t('AUTH.REGISTER.FORM.BIRTHDAY')" />

          <Input
              id="birthday"
              type="date"
              class="mt-1 block w-full"
              v-model="userData.birthday"
              autocomplete="birthday"
              required
          />

          <ErrorList error-key="birthday" :errors="errors"  />
        </div>

        <div>
          <Label for="password" :value="$t('AUTH.REGISTER.FORM.PASSWORD')" />

          <Input
            id="new-password"
            type="password"
            class="mt-1 block w-full"
            v-model="userData.password"
            autocomplete="new-password"
            required
          />

          <ErrorList error-key="password" :errors="errors"  />
        </div>

        <ErrorList error-key="message" :errors="errors"  />

        <button type="submit" class="dark-gray-btn"> {{ $t('AUTH.REGISTER.FORM.SUBMIT') }} </button>
        
        <hr class="my-6 border-gray-300 w-full" />
        
        <div class="btn border border-1">
            <GoogleIcon />
            <span class="ml-4">{{ $t('AUTH.REGISTER.FORM.REGISTER_GOOGLE') }}</span>
        </div>

        <div class="mt-6 font-">
          {{ $t('AUTH.REGISTER.FORM.ALREADY_REGISTERED') }}
          <router-link :to="{ name: 'login' }" class="font-semibold text-blue-400">{{ $t('AUTH.REGISTER.FORM.LOGIN') }}</router-link>
        </div>
      </form>
    </Panel>
  </div>
</template>

<script setup>
import {inject, ref} from 'vue';
import authService from '@/services/authService';
import router from '@/router'
import {useI18n} from 'vue-i18n';

import Panel from '@/components/shared/Panel.vue'
import Input from '@/components/form/Input.vue'
import Label from '@/components/form/Label.vue'
import ErrorList from "@/components/errors/ErrorList.vue";
import HeaderText from '@/components/shared/HeaderText.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'

const toast = inject('toast');
const { t } = useI18n();

const userData = ref({
  name: '',
  email: '',
  birthday: '01/01/2000',
  password: '',
})

const errors = ref({
  name: [],
  email: [],
  birthday: [],
})

const formSubmit = async (event) => {
  event.preventDefault()

  try {
    await authService.register(userData.value);

    toast.success(t('AUTH.REGISTER.FORM.SUCCESS'));

    await router.push('/');
  } catch (error) {
    errors.value = error.errors ?? {};
  }
}
</script>

