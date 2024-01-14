<template>
    <div class="flex flex-col w-full">
      <Panel class="w-full p-4 mt-0">
        <PanelHeader class="p-2">
          <template v-slot:title> {{ $t('PROFILE_SETTINGS.TITLE') }} </template>
          <template v-slot:description> {{ $t('PROFILE_SETTINGS.DESCRIPTION') }} </template>
          <hr>
        </PanelHeader>

        <form @submit="submitUserInfo($event)" method="POST" class="flex flex-col gap-4">
          <div>
            <Label for="name" :value="$t('PROFILE_SETTINGS.FORM.NAME.LABEL')" />

            <Input
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="userData.name"
              autofocus
              autocomplete="username"
              :placeholder="$t('PROFILE_SETTINGS.FORM.NAME.PLACEHOLDER')"
            />

            <div v-if="errors?.name && errors?.name.length > 0">
              <InputError class="mt-2" :message="errors.name[0]" />
            </div>
          </div>

          <div>
            <Label for="email" :value="$t('PROFILE_SETTINGS.FORM.EMAIL.LABEL')" />

            <Input
              id="email"
              type="text"
              class="mt-1 block w-full"
              v-model="userData.email"
              autocomplete="email"
              :placeholder="$t('PROFILE_SETTINGS.FORM.EMAIL.PLACEHOLDER')"
            />

            <div v-if="errors?.email && errors?.email.length > 0">
              <InputError class="mt-2" :message="errors.email[0]" />
            </div>
          </div>

          <button type="submit" class="dark-gray-btn w-40">{{ $t('PROFILE_SETTINGS.FORM.SUBMIT_BUTTON') }}</button>
        </form>
      </Panel>
    </div>
</template>

<script setup>
import { computed, ref, inject } from "vue";
import { useStore } from "vuex";
import { validateEmail } from '@/utils/helpers';
import userService from '@/services/userService';
import { useI18n } from 'vue-i18n';

import Panel from "@/components/shared/Panel.vue";
import PanelHeader from "@/components/shared/PanelHeader.vue";
import Input from "@/components/form/Input.vue";
import Label from "@/components/form/Label.vue";
import InputError from "@/components/form/InputError.vue";

const toast = inject('toast');
const store = useStore();
const { t } = useI18n();

const currentUser = computed(() => store.getters["_currentUser"]);

const userData = ref({
  name: currentUser.value.name,
  email: currentUser.value.email
});

const errors = ref({});

const submitUserInfo = async (event) => {
  event.preventDefault();
  errors.value = {};

  const payload = userData.value;

  if(payload.email.length === 0) {
    errors.value.email = [t('PROFILE_SETTINGS.FORM.EMAIL.EMPTY_ERROR')];
  } else if (!validateEmail(payload.email)) {
    errors.value.email = [t('PROFILE_SETTINGS.FORM.EMAIL.INVALID_ERROR')]
  }

  if(payload.name.length === 0) {
    errors.value.name = [t('PROFILE_SETTINGS.FORM.NAME.EMPTY_ERROR')];
  } else if (payload.name.length > 50 || payload.name.length < 3) {
    errors.value.name = [t('PROFILE_SETTINGS.FORM.NAME.CHAR_LIMIT_ERROR')]
  }

  if(Object.keys(errors.value).length === 0) {
    try {
      await userService.updateUser(payload);
      

      toast.success(t('PROFILE_SETTINGS.FORM.SUCCESS_MESSAGE'));
    } catch (error) {
      errors.value = error.errors;

      toast.error(error.title);
    }
    
  }
};
</script>
