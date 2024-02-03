<template>
    <div>
        <HeaderText class="text-center">{{ $t('AUTH.FORGOT_PASSWORD.TITLE') }}</HeaderText>
        <Panel class="max-w-lg w-full mb-16 mt-8 p-8">
            <div v-if="pageState === 0">
                <form @submit="formSubmit($event)">
                <div>
                    <img class="w-full mt-4"  src="/images/auth/forgot-password.png">
                    <div class="mb-4 text-sm text-gray-800" v-html="$t('AUTH.FORGOT_PASSWORD.DESCRIPTION')" />

                    <Label for="email" :value="$t('FIELDS.EMAIL')" />

                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="userData.email"
                        autocomplete="username"
                        required
                    />

                    <ErrorList errorKey="email" :errors="errors" />
                </div>

                <div v-if="errors?.message && errors?.message?.length" class="text-red-500 font-semibold my-4">
                    {{ errors?.message }}
                </div>

                <button type="submit" class="dark-gray-btn w-full mt-4"> {{ $t('AUTH.FORGOT_PASSWORD.FORM_SUBMIT') }} </button>
            </form>
            </div>
            <div v-else-if="pageState === 1">
                <div class="text-center">
                    <img class="w-full mt-4"  src="/images/auth/forgot-password-success.png">
                    <div class="my-4 text-gray-800 font-semibold" v-html="$t('AUTH.FORGOT_PASSWORD.SUCCESS_MESSAGE')" />
                </div>
            </div>
            
        </Panel>
    </div>
</template>

<script setup>
import {inject, ref, watch} from 'vue'
import router from '@/router'
import authService from '@/services/authService'
import {useI18n} from 'vue-i18n';

import Panel from '@/components/shared/Panel.vue'
import Input from '@/components/form/Input.vue'
import Label from '@/components/form/Label.vue'
import HeaderText from '@/components/shared/HeaderText.vue'
import ErrorList from '@/components/errors/ErrorList.vue'

const toast = inject('toast');
const { t } = useI18n();

const userData = ref({
    email: ''
});

const errors = ref({
    email: []
});

const pageState = ref(0);


const formSubmit = async (event) => {
    event.preventDefault();

    try {
        if(validateForm()) {
            await authService.forgotPassword(userData.value.email);

            pageState.value = 1;

            setTimeout(() => {
                router.push({ name: 'login' });
            }, 60000);
        }
    } catch (error) {
        errors.value = error.data ?? {};

        !error.data && toast.error(error?.message);
    }
}

const validateForm = () => {
    errors.value.email = isEmpty(userData?.value?.email) ? [t('AUTH.LOGIN.FORM.EMAIL_EMPTY_ERROR')] : [];

    if(errors.value.message?.length) {
        errors.value.message = ''
    }

    return Object.keys(errors.value).every((field) => errors.value[field].length === 0)
}

const isEmpty = (field) => (field ?? '').trim().length === 0;

watch(userData.value, validateForm)
</script>
