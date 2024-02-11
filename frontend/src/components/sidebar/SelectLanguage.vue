<template>
    <div>
        <DropDownSelect
        :options="locales"
        readValue="value"
        readText="name"
        imageField="flag"
        v-model="locale"
        class="mb-4"
        @onSelect="onLanguageChange($event)">
          <template #option="option">
              <div class="flex gap-2 items-center justify-start">
                  <img :src="option.flag ?? ''" class="w-6 h-6" />
                  {{ option.name }}
              </div>
          </template>
        </DropDownSelect>
    </div>
</template>

<script>
import DropDownSelect from '@/components/shared/DropdownSelect.vue';
import useLocale from "@/composables/locale";

const { locale, locales, onLanguageSelect } = useLocale();
export default {
  setup() {
    return {
      DropDownSelect,
      locale,
      locales,
      onLanguageSelect,
    }
  },
  components: {
    DropDownSelect
  },
  methods: {
    onLanguageChange(lang) {
      onLanguageSelect(lang.value, () => {
        this.$i18n.locale = lang.value;
      });
    }
  }
}
</script>
