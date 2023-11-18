<script>
import UserLayout from '@/Layouts/UserLayout.vue';
import LayoutContainer from '@/Components/LayoutContainer.vue';

export default {
  components: {
    UserLayout,
    LayoutContainer,
  },

}
</script>

<template>
  <UserLayout>
    <LayoutContainer>
      <div class="h-80 mt-12 rounded-md flex items-center">
        <div class=" w-3/5 p-3">
          <div class="mt-6 text-[1.75rem] font-extrabold leading-9 tracking-tight text-slate-900 md:text-4xl">
            <div>
              <p
                class="inline-block px-3 py-px mb-4 text-xs font-semibold tracking-wider text-teal-900 uppercase rounded-full bg-teal-accent-400">
                Powerload nedir?
              </p>
            </div>

            Progressive Overload
            <br>
            ağırlıklarınla birlikte büyü!
          </div>
          <p class="mt-3">Progressive Overload belirli biz dönem içinde sürekli olarak <b>ağırlık/tekrar </b> arttırarak
            <b>güç ve kas</b> kazanımında fayda sağlayan bir metoddur.</p>
          <p class="mt-3">Bu uygulama ile <b>antrenmanlarını</b> ve <b>ağırlıklarını</b> kolayca takip edebiliceksin!</p>
        </div>
        <div class=" w-2/5">
          <img src="/images/milo-of-croton.jpg">
        </div>
      </div>

      <!-- Step by step -->
      <div class=" py-4 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl  lg:py-10">

        <div class="relative grid gap-8 row-gap-5 mb-8 md:row-gap-8 lg:grid-cols-4 sm:grid-cols-2">
          <div class="absolute inset-0 flex items-center justify-center sm:hidden lg:flex">
            <div class="w-px h-full bg-gray-300 lg:w-full lg:h-px"></div>
          </div>
          <div class="p-5 duration-300 transform bg-white border rounded shadow-sm hover:-translate-y-2">
            <div class="flex items-center justify-between mb-2">
              <p class="text-lg font-bold leading-5">Üye Ol</p>
              <p
                class="flex items-center justify-center w-6 h-6 font-bold rounded text-deep-purple-accent-400 bg-indigo-50">
                1
              </p>
            </div>
            <p class="text-sm text-gray-900">
              Ücretsiz bir şekilde üyeliğini oluşturabilir ve uygulamayı kullanmaya başlayabilirsin.
            </p>
          </div>
          <div class="p-5 duration-300 transform bg-white border rounded shadow-sm hover:-translate-y-2">
            <div class="flex items-center justify-between mb-2">
              <p class="text-lg font-bold leading-5">Antrenman Yap</p>
              <p
                class="flex items-center justify-center w-6 h-6 font-bold rounded text-deep-purple-accent-400 bg-indigo-50">
                2
              </p>
            </div>
            <p class="text-sm text-gray-900">
              En iyi sonuçları sadece düzenli antrenman yaparak alabilirsin!
            </p>
          </div>
          <div class="p-5 duration-300 transform bg-white border rounded shadow-sm hover:-translate-y-2">
            <div class="flex items-center justify-between mb-2">
              <p class="text-lg font-bold leading-5">Notunu Al</p>
              <p
                class="flex items-center justify-center w-6 h-6 font-bold rounded text-deep-purple-accent-400 bg-indigo-50">
                3
              </p>
            </div>
            <p class="text-sm text-gray-900">
              Antrenmanda güçlenmek istediğin hareketlerde ağırlıkları ve tekrarları not al.
            </p>
          </div>
          <div class="p-5 duration-300 transform bg-white border rounded shadow-sm hover:-translate-y-2">
            <div class="flex items-center justify-between mb-2">
              <p class="text-lg font-bold leading-5">Analiz Et!</p>
              <p
                class="flex items-center justify-center w-6 h-6 font-bold rounded text-deep-purple-accent-400 bg-indigo-50">
                4
              </p>
            </div>
            <p class="text-sm text-gray-900">
              Geçmişe dönük kaldırdığın ağırlıkların artışlarını takip edip ilerlemeni analiz et!
            </p>
          </div>
        </div>

    </div>

  </LayoutContainer>
</UserLayout>
</template>