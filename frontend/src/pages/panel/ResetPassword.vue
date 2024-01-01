<template>
        <Panel class="w-full p-4">
          <PanelHeader
            title="Şifre Yenile"
            description="Şifre oluştururken en az 6 karakter, büyük ve küçük harflerden oluşmasına dikkat etmelisiniz. Zorunlu değil sadece tavsiye 🙃"
          />

        <form @submit="submitPassword($event)" method="POST" class="flex flex-col gap-4">
          <div>
            <Label for="currentPassword" value="Güncel Şifre" />

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
            <Label for="newPassword" value="Yeni Şifre" />

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
            <Label for="newPasswordConfirm" value="Yeni Şifre Onay" />

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

          <ButtonCmp
            type="submit"
            class="bg-gray-800 hover:bg-gray-600 active:bg-gray-700 text-white mt-4 text-lg w-24"
            >Güncelle
          </ButtonCmp>
        </form>
      </Panel>
</template>

<script setup>
import { ref, computed, inject } from "vue";
import CryptoJs from 'crypto-js'
import { useStore } from 'vuex';

import Panel from "@/components/form/Panel.vue";
import PanelHeader from "@/components/panel/PanelHeader.vue";
import Input from "@/components/form/Input.vue";
import Label from "@/components/form/Label.vue";
import InputError from "@/components/form/InputError.vue";
import ButtonCmp from "@/components/buttons/ButtonCmp.vue";

const axios = inject('axios');
const toastr = inject('toastr');
const store = useStore();
const saltKey = computed(() => store.getters['_saltKey']);

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
    errors.value.currentPassword = ['Şifre boş olamaz.'];
  } 

  if(payload.newPassword.length === 0) {
    errors.value.newPassword = ['Yeni Şifre boş olamaz..'];
  } 

  if(payload.newPasswordConfirm.length === 0) {
    errors.value.newPasswordConfirm = ['Yeni Şifre Onay boş olamaz.'];
  } else if(payload.newPasswordConfirm !== payload.newPassword) {
    errors.value.newPasswordConfirm = ['Yeni şifreler uyuşmuyor!'];
  }

  const cryptedCurrenetPassword = CryptoJs.HmacSHA1(payload.currentPassword, saltKey.value).toString();
  const cryptedNewPassword = CryptoJs.HmacSHA1(payload.newPassword, saltKey.value).toString();

  if(Object.keys(errors.value).length === 0) {
   try {
    const response = await axios.patch('/user/update-password', {
      currentPassword: cryptedCurrenetPassword,
      newPassword: cryptedNewPassword,
      newPasswordConfirm: cryptedNewPassword
    });
    
    toastr.success('Şifre başarıyla güncellendi!');

    newPassword.value  = {};

   } catch (error) {
    toastr.error(error.message);
   }
  }  
};




</script>
