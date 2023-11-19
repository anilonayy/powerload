<template>
    <UserLayout>
        <LayoutContainer>
            <HeaderText class="text-center"> Giriş Yap </HeaderText>
            <Panel class="max-w-lg w-full">
                <form  @submit="formSubmit($event)">
                    <div>
                        <Label for="email" value="E-Posta" />

                        <Input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                            autocomplete="username" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <Label for="password" value="Şifre" />

                        <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                            autocomplete="current-password" />

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex justify-end">
                        <ButtonCmp type="submit" class="bg-gray-800 text-white mt-4 w-full text-lg">Giriş Yap</ButtonCmp>
                    </div>
                </form>
            </Panel>

        </LayoutContainer>
    </UserLayout>
</template>

<script setup>
import { ref } from 'vue';
import appAxios from '@/Utils/appAxios'
import UserLayout from '@/Layouts/UserLayout.vue';
import LayoutContainer from '@/Components/LayoutContainer.vue';
import Panel from '@/Components/Form/Panel.vue';
import Input from '@/Components/Form/Input.vue';
import InputError from '@/Components/Form/InputError.vue';
import Label from '@/Components/Form/Label.vue';
import HeaderText from '@/Components/HeaderText.vue';
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';


const form = ref({
    email: '',
    password: '',
    errors: {}
});

const formSubmit = (event) => {
    event.preventDefault();

    console.log('Form Submitted');
}
</script>

