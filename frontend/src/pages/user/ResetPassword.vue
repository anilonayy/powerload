<template>
        <Panel class="w-full p-4">
        <PanelHeader class="p-2">
          <template v-slot:title> {{ $t('RESET_PASSWORD.TITLE') }} </template>
          <template v-slot:description> {{ $t('RESET_PASSWORD.DESCRIPTION') }} </template>
          <hr>
        </PanelHeader>

        <form @submit="submitPassword($event)" method="POST" class="flex flex-col gap-4">
          <div>
            <Label for="currentPassword" :value="$t('RESET_PASSWORD.FORM.CURRENT_PASSWORD.LABEL')" />

            <Input
              id="currentPassword"
              type="password"
              class="mt-1 block w-full"
              v-model="newPassword.currentPassword"
            />

            <div v-if="errors?.currentPassword && errors?.currentPassword.length > 0">
              <InputError class="mt-2" :message="errors.currentPassword[0]" />
            </div>
          </div>

          <div>
            <Label for="newPassword" :value="$t('RESET_PASSWORD.FORM.NEW_PASSWORD.LABEL')" />

            <Input
              id="newPassword"
              type="password"
              class="mt-1 block w-full"
              v-model="newPassword.newPassword"
            />

            <div v-if="errors?.newPassword && errors?.newPassword.length > 0">
              <InputError class="mt-2" :message="errors.newPassword[0]" />
            </div>
          </div>

          <div>
            <Label for="newPasswordConfirm" :value="$t('RESET_PASSWORD.FORM.NEW_PASSWORD_CONFIRMATION.LABEL')" />

            <Input
              id="newPasswordConfirm"
              type="password"
              class="mt-1 block w-full"
              v-model="newPassword.newPasswordConfirm"
            />

            <div
              v-if="errors?.newPasswordConfirm && errors?.newPasswordConfirm.length > 0"
            >
              <InputError class="mt-2" :message="errors.newPasswordConfirm[0]" />
            </div>
          </div>

          <button class="dark-gray-btn w-40"> {{ $t('RESET_PASSWORD.FORM.SUBMIT_BUTTON') }} </button>
        </form>
      </Panel>
</template>

<script setup>
import { ref, inject } from "vue";
import { useI18n } from 'vue-i18n'
import userService from '@/services/userService';

import Panel from "@/components/shared/Panel.vue";
import PanelHeader from "@/components/shared/PanelHeader.vue";
import Input from "@/components/form/Input.vue";
import Label from "@/components/form/Label.vue";
import InputError from "@/components/form/InputError.vue";

const toast = inject('toast');
const { t } = useI18n();

const errors = ref({});


const newPassword = ref({
  currentPassword: "",
  newPassword: "",
  newPasswordConfirm: "",
});


const submitPassword = async (event) => {
  event.preventDefault();
  errors.value = {};

  const payload = newPassword.value;

  if(payload.currentPassword.length === 0) {
    errors.value.currentPassword = [t('RESET_PASSWORD.FORM.CURRENT_PASSWORD.EMPTY_ERROR')];
  } 

  if(payload.newPassword.length === 0) {
    errors.value.newPassword = [t('RESET_PASSWORD.FORM.NEW_PASSWORD.EMPTY_ERROR')];
  } 

  if(payload.newPasswordConfirm.length === 0) {
    errors.value.newPasswordConfirm = [t('RESET_PASSWORD.FORM.NEW_PASSWORD_CONFIRMATION.EMPTY_ERROR')];
  } else if(payload.newPasswordConfirm !== payload.newPassword) {
    errors.value.newPasswordConfirm = [t('RESET_PASSWORD.FORM.NEW_PASSWORD_CONFIRMATION.MATCH_ERROR')];
  }

  if(Object.keys(errors.value).length === 0) {
    try {
      await userService.updatePassword(newPassword.value);
      toast.success(t('RESET_PASSWORD.FORM.SUCCESS_MESSAGE'));

      newPassword.value  = {};
    } catch (error) {
      toast.error(error.message);
    }
  }  
};




</script>
