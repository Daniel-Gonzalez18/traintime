<script setup lang="ts">
import Cabecera from '@/components/Cabecera.vue';
import PieDePagina from '@/components/PieDePagina.vue';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

const props = defineProps<{
  calendarToken: string;
  eventosFullCalendar: Array<any>;
}>()

function connectWithGoogle() {
  window.location.href = '/auth/google';
}
const calendarOptions = {
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  events: props.eventosFullCalendar,
}

</script>

<template>
  <div v-if="calendarToken" flex justify-center bg-black w-full>
    <div class="flex justify-center bg-black w-full h-20">
      <Cabecera top-0 fixed :enlaces="[
        { titulo: 'INICIO', href: 'home' },
        { titulo: 'RUTINA', href: 'rutina' },
        { titulo: 'PROGRESO', href: 'progreso' },
        { titulo: 'GRUPO', href: 'grupo' }
      ]" />
    </div>
    <section class="bg-black flex flex-col w-full text-center">
      <a href="https://calendar.google.com/calendar/u/0/r" class="text-[#FFA726] m-10">ABRIR GOOGLE
        CALENDAR</a>
      <FullCalendar :options="calendarOptions" class="text-white w-full max-w-[1000px] mx-auto mb-10 " />
    </section>
    <PieDePagina />
  </div>
  <div class="bg-black w-full h-screen" v-else>
    <a href="/" class="mt-10 ml-10 inline-block">
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 12 12">
        <path fill="#fff"
          d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
      </svg>
    </a>

    <div class="justify-center items-center h-3/4 bg-black flex flex-col">
      <p class="text-white text-xl">Para poder accerder a esta página debes estar conectado con Google Calendar</p>
      <button @click="connectWithGoogle" class="mt-4 bg-[#D9D9D9] text-black px-4 py-2 rounded font-bold">
        Conectar con Google Calendar
      </button>
    </div>
  </div>
</template>