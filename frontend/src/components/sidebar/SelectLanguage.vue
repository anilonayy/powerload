<template>
    <div>
        <DropDownSelect
        :options="langs"
        readValue="value"
        readText="name"
        imageField="flag"
        v-model="selectedLang"
        class="mb-4"
        @onSelect="onLanguageSelect($event)"
    >
        <template #option="option">
            <div class="flex gap-2 items-center justify-start">
                <img :src="option.flag" class="w-6 h-6" />
                {{ option.name }}
            </div>
        </template>
    </DropDownSelect>
    </div>
</template>

<script>
import {ref} from 'vue';
import {getLocale, setCookie} from '@/utils/helpers'

import DropDownSelect from '@/components/shared/DropdownSelect.vue';

export default {
    setup() {
        const langs = [
            {
                name: 'English',
                value: 'en_US',
                flag: '/images/flags/en_EN.png'
            },
            {
                name: 'Türkçe',
                value: 'tr_TR',
                flag: '/images/flags/tr_TR.png'
            }
        ];

        const selectedLang = ref(langs.find(x => x.value == getLocale()));

        return {
            langs,
            selectedLang,
        };
    },
    components: {
        DropDownSelect
    },
    methods: {
        onLanguageSelect(lang) {
            this.$i18n.locale = lang.value;
            setCookie('locale', lang.value, 365)

        }
    }
}

</script>
