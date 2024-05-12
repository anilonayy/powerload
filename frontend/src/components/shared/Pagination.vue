<template>
  <RenderlessPagination
    :data="data"
    :limit="limit"
    :keep-length="keepLength"
    @pagination-change-page="onPaginationChangePage"
    v-slot="slotProps"
  >
    <nav
      v-bind="$attrs"
      aria-label="Pagination"
      v-if="slotProps.computed.total > slotProps.computed.perPage"
      class="flex flex-col mt-4 text-xs"
    >
      <div class="flex gap-2 items-center flex-start">
        <button
          :disabled="!slotProps.computed.prevPageUrl"
          v-on="slotProps.prevButtonEvents"
          :class="{ 'pointer-events-none opacity-50': !slotProps.computed.prevPageUrl }"
        >
          <slot name="prev-nav">
            <div class="p-2 rounded hover:bg-gray-100 cursor-pointer">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </div>
          </slot>
        </button>

        <button
          :aria-current="slotProps.computed.currentPage ? 'page' : null"
          v-for="(page, key) in slotProps.computed.pageRange"
          :key="key"
          v-on="slotProps.pageButtonEvents(page)"
        >
          <div
            class="px-4 py-2 rounded hover:bg-gray-100"
            :class="{ 'bg-gray-200 text-gray-900': slotProps.computed.currentPage === page }"
          >
            {{ page }}
          </div>
        </button>

        <button
          :disabled="!slotProps.computed.nextPageUrl"
          v-on="slotProps.nextButtonEvents"
          :class="{ 'pointer-events-none opacity-50': !slotProps.computed.nextPageUrl }"
        >
          <slot name="next-nav">
            <div class="p-2 rounded hover:bg-gray-100">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </div>
          </slot>
        </button>
      </div>
      <p class="text-gray-500 text-xs mt-4">
        {{
          $t('PAGINATION.TEXT', {
            from: slotProps.computed.from,
            to: slotProps.computed.to,
            total: slotProps.computed.total
          })
        }}
      </p>
    </nav>
  </RenderlessPagination>
</template>

<script>
import RenderlessPagination from 'laravel-vue-pagination/src/RenderlessPagination.vue';
import RightIcon from '@/components/icons/RightIcon.vue';
export default {
  inheritAttrs: false,

  emits: ['pagination-change-page'],

  components: {
    RightIcon,
    RenderlessPagination
  },

  props: {
    data: {
      type: Object,
      default: () => {}
    },
    limit: {
      type: Number,
      default: 0
    },
    keepLength: {
      type: Boolean,
      default: false
    }
  },

  methods: {
    onPaginationChangePage(page) {
      this.$emit('pagination-change-page', page);
    }
  }
};

// from https://github.com/gilbitron/laravel-vue-pagination <3
</script>
