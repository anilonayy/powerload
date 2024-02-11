import { ref, computed } from 'vue';
import store from '@/store';

export default function useLocale()  {
    const locale = ref(store.getters['_getLocales'].find((locale) => locale.value === store.getters['_getLocale']));
    const locales = store.getters['_getLocales'];

    const onLanguageSelect = async (locale, success) => {
        await store.dispatch('setLocale', locale);
        success();
    };

    return { locale, locales, onLanguageSelect};
}