<template>
  <Panel class="w-full p-4">
    <PanelHeader class="p-2">
      <template v-slot:title> {{ $t('RESET_PASSWORD.TITLE') }} </template>
      <template v-slot:description> {{ $t('RESET_PASSWORD.DESCRIPTION') }} </template>
      <hr />
    </PanelHeader>

    <form @submit="updatePassword($event)" method="POST" class="flex flex-col gap-4" autocomplete="off">
      <div>
        <Label for="currentPassword" :value="$t('FIELDS.CURRENT_PASSWORD')" />

        <Input
          id="currentPassword"
          type="password"
          class="mt-1 block w-full"
          v-model="passwordData.currentPassword"
          autocomplete="off"
        />

        <ErrorList error-key="currentPassword" :errors="errors" />
      </div>

      <div>
        <Label for="passwordData" :value="$t('FIELDS.NEW_PASSWORD')" />

        <Input
          id="passwordData"
          type="password"
          class="mt-1 block w-full"
          v-model="passwordData.newPassword"
          autocomplete="off"
        />

        <ErrorList error-key="newPassword" :errors="errors" />
      </div>

      <div>
        <Label for="newPasswordConfirm" :value="$t('FIELDS.NEW_PASSWORD_CONFIRM')" />

        <Input
          id="newPasswordConfirm"
          type="password"
          class="mt-1 block w-full"
          v-model="passwordData.newPasswordConfirm"
          autocomplete="off"
        />

        <ErrorList error-key="newPasswordConfirm" :errors="errors" />
      </div>

      <button class="dark-gray-btn w-40">{{ $t('RESET_PASSWORD.FORM.SUBMIT_BUTTON') }}</button>
    </form>
  </Panel>
</template>

<script setup>
import useUser from '@/composables/user';

import Panel from '@/components/shared/Panel.vue';
import PanelHeader from '@/components/shared/PanelHeader.vue';
import Input from '@/components/form/Input.vue';
import Label from '@/components/form/Label.vue';
import ErrorList from '@/components/errors/ErrorList.vue';

const { passwordData, errors, updatePassword } = useUser();
</script>
