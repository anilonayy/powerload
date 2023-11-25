<template>
    <UserLayout>
        <LayoutContainer>
            <HeaderText class="text-center"> Üye Ol </HeaderText>
            <Panel class="max-w-lg w-full my-16">
                <form @submit="formSubmit($event)" class="flex flex-col gap-4">
                    <div>
                        <Label for="name" value="Ad Soyad" />

                        <Input id="name" type="text" class="mt-1 block w-full" v-model="userData.name" autofocus
                            autocomplete="username" />

                        <div v-if="errors?.name && errors?.name.length > 0">
                            <InputError class="mt-2" :message="errors.name[0]" />
                        </div>
                    </div>

                    <div>
                        <Label for="email" value="E-Posta" />

                        <Input id="email" type="email" class="mt-1 block w-full" v-model="userData.email" autofocus
                            autocomplete="username" />

                        <div v-if="errors?.email && errors?.email.length > 0">
                            <InputError class="mt-2" :message="errors.email[0]" />
                        </div>
                    </div>

                    <div>
                        <Label for="password" value="Şifre" />

                        <Input id="password" type="password" class="mt-1 block w-full" v-model="userData.password"
                            autocomplete="current-password" />

                        <div v-if="errors?.password && errors?.password.length > 0">
                            <InputError class="mt-2" :message="errors.password[0]" />
                        </div>
                    </div>

                    <div>
                        <Label for="password_confirm" value="Şifre Onay" />

                        <Input id="password_confirm" type="password" class="mt-1 block w-full"
                            v-model="userData.password_confirm" />

                        <div v-if="errors?.password_confirm && errors?.password_confirm.length > 0">
                            <InputError class="mt-2" :message="errors.password_confirm[0]" />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <ButtonCmp type="submit"
                            class="bg-gray-800 hover:bg-gray-600 active:bg-gray-700 text-white mt-4 w-full text-lg">Üye Ol
                        </ButtonCmp>
                    </div>

                    <hr class="my-6 border-gray-300 w-full">

                    <ButtonCmp
                        class="w-full bg-white hover:bg-gray-100 focus:bg-gray-100 text-gray-900 font-semibold rounded-lg border border-gray-300">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                class="w-6 h-6" viewBox="0 0 48 48">
                                <defs>
                                    <path id="a"
                                        d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                                </defs>
                                <clipPath id="b">
                                    <use xlink:href="#a" overflow="visible" />
                                </clipPath>
                                <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                                <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                                <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                                <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                            </svg>
                            <span class="ml-4">Google ile üye ol</span>
                        </div>
                    </ButtonCmp>

                    <div class="mt-6 font-">
                        Zaten üye misin? <router-link to="/giris-yap" class="font-semibold text-blue-400">Giriş
                            Yap</router-link>
                    </div>


                </form>
            </Panel>

        </LayoutContainer>
    </UserLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import CryptoJs from 'crypto-js'
import axios from '@/Utils/axios';
import { useStore } from 'vuex';
import toastr from 'toastr';
import router from '@/Router';
import UserLayout from '@/Layouts/UserLayout.vue';
import LayoutContainer from '@/Components/Shared/LayoutContainer.vue';
import Panel from '@/Components/Form/Panel.vue';
import Input from '@/Components/Form/Input.vue';
import InputError from '@/Components/Form/InputError.vue';
import Label from '@/Components/Form/Label.vue';
import HeaderText from '@/Components/Shared/HeaderText.vue';
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';

const store = useStore();
const saltKey = computed(() => store.getters['_saltKey']);

const userData = ref({
    name: '',
    email: '',
    password: '',
    password_confirm: ''
});

const errors = ref({});

const formSubmit = async (event) => {
    event.preventDefault();

    let cryptedPassword = '';
    let cryptedPasswordConfirm = '';

    if (userData.value.password.length > 0 && userData.value.password_confirm) {
        cryptedPassword = CryptoJs.HmacSHA1(userData.value.password, saltKey.value).toString();
        cryptedPasswordConfirm = CryptoJs.HmacSHA1(userData.value.password_confirm, saltKey.value).toString();
    }


    try {
        const response = await axios.post('/register', { ...userData.value, password: cryptedPassword, password_confirm: cryptedPasswordConfirm });


        store.dispatch('register',response.data.user);
        localStorage.setItem('_token', response.data.token);

        Object.keys(userData.value).forEach(field => userData.value[field] = null); // Remove all values

        router.push('/');
    } catch (error) {
        errors.value = error.response.data.data.errors;
        toastr.error(error.response.data.message);
    }

}
</script>

