import { getLocale } from '@/utils/helpers';
import { createI18n } from 'vue-i18n';
import trMessages from '@/lang/tr_TR';
import enMessages from '@/lang/en_EN';

const i18n = createI18n({
    legacy: false, // you must set `false`, to use Composition API
    locale: getLocale(), 
    fallbackLocale: 'tr_TR',
    messages: {
        tr_TR: trMessages,
        en_EN: enMessages,
    }
})

export default i18n;