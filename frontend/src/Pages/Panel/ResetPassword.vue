<template>
    <PanelLayout>
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
              type="text"
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
              type="text"
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
              type="text"
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
            class="bg-gray-800 hover:bg-gray-600 active:bg-gray-700 text-white mt-4 w-full text-lg w-24"
            >Güncelle
          </ButtonCmp>
        </form>
      </Panel>
    </PanelLayout>
</template>

<script setup>
import { ref } from "vue";

import PanelLayout from "@/Layouts/PanelLayout.vue";
import Panel from "@/Components/Form/Panel.vue";
import PanelHeader from "@/Components/Panel/PanelHeader.vue";
import Input from "@/Components/Form/Input.vue";
import Label from "@/Components/Form/Label.vue";
import InputError from "@/Components/Form/InputError.vue";
import ButtonCmp from "@/Components/buttons/ButtonCmp.vue";



const errors = ref({});


const newPassword = ref({
  currentPassword: "",
  newPassword: "",
  newPasswordConfirm: "",
});


const submitPassword = (event) => {
  event.preventDefault();

  console.log("event :>> ", event);
};


</script>
