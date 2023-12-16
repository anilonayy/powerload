<template>
    <div class="flex flex-col w-full">
      <Panel class="w-full p-4 mt-0">
        <PanelHeader
          title="Profil Ayarları"
          description="Hitap edebilmemiz için ismin, iletişime geçmemiz için e-posta adresin hepsi bu kadar."
        />

        <form @submit="submitUserInfo($event)" method="POST" class="flex flex-col gap-4">
          <div>
            <Label for="name" value="Ad Soyad" />

            <Input
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="userData.name"
              autofocus
              autocomplete="username"
            />

            <div v-if="errors?.name && errors?.name.length > 0">
              <InputError class="mt-2" :message="errors.name[0]" />
            </div>
          </div>

          <div>
            <Label for="email" value="E-Posta" />

            <Input
              id="email"
              type="text"
              class="mt-1 block w-full"
              v-model="userData.email"
              autocomplete="email"
            />

            <div v-if="errors?.email && errors?.email.length > 0">
              <InputError class="mt-2" :message="errors.email[0]" />
            </div>
          </div>

          <ButtonCmp
            type="submit"
            class="bg-gray-800 hover:bg-gray-600 active:bg-gray-700 text-white mt-4 text-lg inline-block w-24"
            >Güncelle
          </ButtonCmp>
        </form>
      </Panel>
    </div>
</template>

<script setup>
import { computed, ref, inject } from "vue";
import { useStore } from "vuex";
import { validateEmail } from '@/utils/helpers.js';

import Panel from "@/components/form/Panel.vue";
import PanelHeader from "@/components/panel/PanelHeader.vue";
import Input from "@/components/form/Input.vue";
import Label from "@/components/form/Label.vue";
import InputError from "@/components/form/InputError.vue";
import ButtonCmp from "@/components/buttons/ButtonCmp.vue";

const axios = inject('axios');
const toast = inject('toast');

const store = useStore();

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
    errors.value.email = ['E-Posta adresi boş olamaz.'];
  } else if (!validateEmail(payload.email)) {
    errors.value.email = ['Lütfen geçerli bir e-mail adresi girin.']
  }

  if(payload.name.length === 0) {
    errors.value.name = ['Ad Soyad boş olamaz!'];
  } else if (payload.name.length > 40) {
    errors.value.name = ['Ad soyad 40 karakterden fazla olamaz.']
  }

  if(Object.keys(errors.value).length === 0) {
    try {
      const response = await axios.patch('/user', payload);
      store.dispatch('updateUser', response.data);

      toast.success(response.message);
    } catch (error) {
      errors.value = error.errors;
      
      toast.error(error.title);
    }
    
  }

};
</script>
