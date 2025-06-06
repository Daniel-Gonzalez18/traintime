<script setup lang="ts">
import PieDePagina from '@/components/PieDePagina.vue';
import Cabecera from '@/components/Cabecera.vue';
import { ref } from 'vue'
import Fase1 from '@/components/Fase1.vue';
import Fase2 from '@/components/Fase2.vue';
import Fase3 from '@/components/Fase3.vue';
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
const fases = [Fase1, Fase2, Fase3]
const faseActual = ref(0)

const formData = ref({
   altura: 0,
   peso: 0,
   experiencia: '',
   numDias: 0,
   objetivo: '',
   diasSeleccionados: [] as string[],
   dias: [] as { nombre: string; inicio: string; fin: string }[]
})
const fase3Ref = ref();


const siguienteFase = async () => {
   if (faseActual.value === 1) {
      if (formData.value.diasSeleccionados.length !== formData.value.numDias) {
         alert(`Debes seleccionar exactamente ${formData.value.numDias} días.`);
         return;
      }
      formData.value.dias = formData.value.diasSeleccionados.map((dia: string) => ({
         nombre: dia,
         inicio: '',
         fin: ''
      }));
   }
   if (faseActual.value === 2) {
      const valido = await fase3Ref.value?.validateHorarios?.();
      if (!valido) return;
   }

   if (faseActual.value < fases.length - 1) {
      faseActual.value++;
   }

};

const faseAnterior = () => {
   faseActual.value--
}
</script>
<template>
   <div class="flex justify-center bg-black w-full h-20">
      <Cabecera top-0 fixed :enlaces="[
         { titulo: 'CALENDARIO', href: 'calendario' },
         { titulo: 'INICIO', href: 'home' },
         { titulo: 'PROGRESO', href: 'progreso' },
         { titulo: 'GRUPO', href: 'grupo' }
      ]" />
   </div>
   <section class="justify-center flex w-full h-100 mx-auto bg-black shadow text-white pt-5">
      <form action="/generate-routine" method="post">
         <input type="hidden" name="altura" :value="formData.altura" />
         <input type="hidden" name="peso" :value="formData.peso" />
         <input type="hidden" name="experiencia" :value="formData.experiencia" />
         <input type="hidden" name="numDias" :value="formData.numDias" />
         <input type="hidden" name="objetivo" :value="formData.objetivo" />
         <input v-for="(dia, index) in formData.dias" :key="index" type="hidden" name="dias[]"
            :value="typeof dia === 'string' ? dia : dia.nombre" />
         <input v-for="(dia, index) in formData.dias" :key="'h' + index" type="hidden"
            :name="`diasData[${index}][inicio]`" :value="dia.inicio" />
         <input v-for="(dia, index) in formData.dias" :key="'f' + index" type="hidden" :name="`diasData[${index}][fin]`"
            :value="dia.fin" />
         <input v-for="(dia, index) in formData.dias" :key="'n' + index" type="hidden"
            :name="`diasData[${index}][nombre]`" :value="dia.nombre" />

         <input type="hidden" name="_token" :value="csrfToken" />

         <div v-if="faseActual < fases.length - 1" @click="faseAnterior" class="cursor-pointer transition"
            title="Siguiente paso">
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 12 12">
               <path fill="#fff"
                  d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
            </svg>
         </div>
         <div class="">
            <component :is="fases[faseActual]" v-model="formData" :ref="faseActual === 2 ? 'fase3Ref' : undefined" />
         </div>
         <div v-if="faseActual < fases.length - 1" @click="siguienteFase" class="cursor-pointer transition"
            title="Siguiente paso">
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 12 12" class="rotate-180">
               <path fill="#fff"
                  d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
            </svg>
         </div>
         <button v-else type="submit" class="px-4 py-2 bg-white-500 text-white rounded">
            Enviar
         </button>
      </form>
   </section>
   <PieDePagina />


</template>