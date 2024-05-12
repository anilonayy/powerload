import { ref, computed, inject } from 'vue';
import { useStore } from 'vuex';
import { isEmpty, isEmail, isKeysEmpty, isAlphabetic } from '@/utils/validateHelper';
import userService from '@/services/userService';
import { useI18n } from 'vue-i18n';
import axios from '@/plugins/appAxios';
import store from '@/store';

export default function useUser() {
  const store = useStore();
  const { t } = useI18n();
  const toast = inject('toast');
  const currentUser = computed(() => store.getters['_currentUser']);

  const userData = ref({
    name: currentUser.value.name,
    email: currentUser.value.email
  });

  const passwordData = ref({
    currentPassword: '',
    newPassword: '',
    newPasswordConfirm: ''
  });

  const errors = ref({});

  const submitUserInfo = async (event) => {
    event.preventDefault();
    errors.value = {};

    const payload = userData.value;

    if (isEmpty(payload.email)) {
      errors.value.email = [{ key: 'ERRORS.VALIDATE.REQUIRED' }];
    } else if (!isEmail(payload.email)) {
      errors.value.email = [{ key: 'ERRORS.VALIDATE.EMAIL' }];
    }

    if (isEmpty(payload.name)) {
      errors.value.name = [{ key: 'ERRORS.VALIDATE.REQUIRED' }];
    } else if (!isAlphabetic(payload.name)) {
      errors.value.name = [{ key: 'ERRORS.VALIDATE.ALPHABET' }];
    } else if (payload.name.length > 50 || payload.name.length < 3) {
      errors.value.name = [{ key: 'ERRORS.VALIDATE.STRING_LENGTH', params: { min: 3, max: 50 } }];
    }

    if (isKeysEmpty(errors.value)) {
      try {
        await userService.updateUser(userData.value);

        toast.success(t('PROFILE_SETTINGS.FORM.SUCCESS_MESSAGE'));
      } catch (error) {
        errors.value = error.errors;

        toast.error(error.title);
      }
    }
  };

  const updatePassword = async (event) => {
    event.preventDefault();
    errors.value = {};

    const payload = passwordData.value;

    if (payload.currentPassword.length === 0) {
      errors.value.currentPassword = [{ key: 'ERRORS.VALIDATE.REQUIRED' }];
    }

    if (payload.newPassword.length === 0) {
      errors.value.newPassword = [{ key: 'ERRORS.VALIDATE.REQUIRED' }];
    }

    if (payload.newPasswordConfirm.length === 0) {
      errors.value.newPasswordConfirm = [{ key: 'ERRORS.VALIDATE.REQUIRED' }];
    } else if (payload.newPasswordConfirm !== payload.newPassword) {
      errors.value.newPasswordConfirm = [{ key: 'ERRORS.VALIDATE.MATCH', params: { field: 'FIELDS.NEW_PASSWORD' } }];
    }

    if (Object.keys(errors.value).length === 0) {
      try {
        await userService.updatePassword(passwordData.value);
        toast.success(t('RESET_PASSWORD.FORM.SUCCESS_MESSAGE'));
      } catch (error) {
        toast.error(error.message);
      }
    }
  };

  return {
    userData,
    passwordData,
    errors,
    submitUserInfo,
    updatePassword
  };
}
