<template>
  <div class="flex flex-col w-full">
    <Panel class="w-full p-4 mt-0">
      <PanelHeader class="p-2">
        <template v-slot:title> {{ $t('PROFILE_SETTINGS.TITLE') }} </template>
        <template v-slot:description> {{ $t('PROFILE_SETTINGS.DESCRIPTION') }} </template>
        <hr />
      </PanelHeader>

      <form @submit="submitUserInfo($event)" method="POST" class="flex flex-col gap-4">
        <div>
          <Label for="name" :value="$t('FIELDS.NAME')" />

          <Input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="userData.name"
            autofocus
            autocomplete="username"
            :placeholder="$t('PROFILE_SETTINGS.FORM.NAME.PLACEHOLDER')"
          />

          <ErrorList error-key="name" :errors="errors" />
        </div>

        <div>
          <Label for="email" :value="$t('FIELDS.EMAIL')" />

          <Input
            id="email"
            type="text"
            class="mt-1 block w-full"
            v-model="userData.email"
            autocomplete="email"
            placeholder="example@gmail.com"
          />

          <ErrorList error-key="email" :errors="errors" />
        </div>

        <button type="submit" class="dark-gray-btn w-40">
          {{ $t('PROFILE_SETTINGS.FORM.SUBMIT_BUTTON') }}
        </button>
      </form>
    </Panel>
  </div>
</template>

<script setup>
import useUser from '@/composables/user';

import Panel from '@/components/shared/Panel.vue';
import PanelHeader from '@/components/shared/PanelHeader.vue';
import Input from '@/components/form/Input.vue';
import Label from '@/components/form/Label.vue';
import ErrorList from '@/components/errors/ErrorList.vue';

const { userData, errors, submitUserInfo } = useUser();
</script>
