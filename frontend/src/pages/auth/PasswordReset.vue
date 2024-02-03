<template>
    <div>
        <HeaderText class="text-center">{{ $t('AUTH.RESET_PASSWORD.TITLE') }}</HeaderText>
        <Panel class="max-w-lg w-full mb-16 mt-8 p-8">
            <form @submit="formSubmit($event)">
                <div>
                    <img class="w-full my-4"  src="/images/auth/reset-password.jpg">
                    <div class="mb-4 text-sm text-gray-800" v-html="$t('AUTH.RESET_PASSWORD.DESCRIPTION')" />

                    <Label for="password" :value="$t('FIELDS.PASSWORD')" />
                    <Input
                        id="password"
                        type="password"
                        class="my-1 block w-full"
                        v-model="userData.password"
                        autocomplete="password "
                    />
                    <ErrorList :errors="errors" errorKey="password" />

                    <Label for="password_confirm" :value="$t('FIELDS.PASSWORD_CONFIRM')" />
                    <Input
                        id="password_confirm"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="userData.password_confirm"
                        autocomplete="password_confirm "
                    />
                    <ErrorList :errors="errors" errorKey="password_confirm" />
                    
                </div>

                <div v-if="errors?.message && errors?.message?.length" class="text-red-500 font-semibold my-4">
                    {{ errors?.message }}
                </div>

                <button type="submit" class="dark-gray-btn w-full mt-4"> {{ $t('AUTH.RESET_PASSWORD.FORM_SUBMIT') }} </button>
            </form>
        </Panel>
    </div>
</template>


<script setup>
import {inject, onMounted, ref, watch} from 'vue';
import {useRoute} from 'vue-router';
import {useI18n} from 'vue-i18n';
import authService from '@/services/authService';
import router from '@/router';

import Panel from '@/components/shared/Panel.vue';
import Label from '@/components/form/Label.vue';
import Input from '@/components/form/Input.vue';
import HeaderText from '@/components/shared/HeaderText.vue';
import ErrorList from '@/components/errors/ErrorList.vue';

const route = useRoute();
const toast = inject('toast');
const swal = inject('swal');
const { t } = useI18n();

const userData = ref({
    password: '',
    password_confirm: ''
});

const errors = ref({
    password: [],
    password_confirm: []
});


onMounted(() => {
    const token = route.params.token;

    if(!token) {
        router.push({ name: 'login' });
    }
})


const formSubmit = async (event) => {
    event.preventDefault();
    
    try {
        if (validateForm()) {
            const response = await authService.resetPassword({
                token: route.params.token,
                email: route.query.email,
                password: userData.value.password,
                password_confirm: userData.value.password_confirm
            });

            swal.fire({
                icon: 'success',
                text: response?.data?.status,
            }).then(() => {
                router.push({ name: 'login' });
            })
        }
    } catch (error) {
        swal.fire({
            icon: 'error',
            text: error.message,
        }).then(() => {
            router.push({ name: 'login' });
        })
    }
}


const validateForm = () => {
    errors.value.password = isEmpty(userData.value.password) ? [t('AUTH.RESET_PASSWORD.ERRORS.PASSWORD_EMPTY_ERROR')] : [];

    if (isEmpty(userData.value.password_confirm)) {
        errors.value.password_confirm = [t('AUTH.RESET_PASSWORD.ERRORS.PASSWORD_CONFIRMATION_EMPTY_ERROR')];
    } else if (userData.value.password !== userData.value.password_confirm) {
        errors.value.password_confirm = [t('AUTH.RESET_PASSWORD.ERRORS.PASSWORD_CONFIRMATION_MATCH_ERROR')];
    } else {
        errors.value.password_confirm = [];
    }

    if(errors.value.message?.length) {
        errors.value.message = ''
    }

    return Object.keys(errors.value).every((field) => errors.value[field].length === 0)
}

const isEmpty = (field) => (field ?? '').trim().length === 0;

watch(userData.value, validateForm)
</script>
