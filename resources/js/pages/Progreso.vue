<script setup lang="ts">
import Cabecera from "@/components/Cabecera.vue";
import PieDePagina from "@/components/PieDePagina.vue";
import { Line } from 'vue-chartjs'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)
const props = defineProps<{ progresos: any }>()
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false }
  },
  scales: {
    y: {
      beginAtZero: true,
      title: { display: true, text: "RM" }
    },
    x: {
      title: { display: true, text: "Fecha" }
    }
  }
}
function graficaData(datos: any[]) {
  return {
    labels: datos.map(p => p.fecha),
    datasets: [
      {
        label: 'RM',
        data: datos.map(p => p.rm),
        borderColor: 'blue',
        backgroundColor: 'rgba(30,144,255,0.2)',
        tension: 0.3,
      }
    ]
  }
}
</script>
<template>
  <div class="h-screen w-full bg-black" v-if="progresos.length === 0">
    <a href="/" class="mt-10 ml-10 inline-block">
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 12 12">
        <path fill="#fff"
          d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
      </svg>
    </a>
    <div class="justify-center items-center h-3/4 bg-black flex flex-col">
      <p class="text-white text-xl">Lo siento, todavia no tienes progresos registrados, cuando los registres vuelve para
        verificarlos</p>
    </div>
  </div>
  <div class="" v-else>
    <div class="flex justify-center bg-black w-full h-20">
      <Cabecera :enlaces="[
        { titulo: 'CALENDARIO', href: 'calendario' },
        { titulo: 'RUTINA', href: 'rutina' },
        { titulo: 'INICIO', href: 'home' },
        { titulo: 'GRUPO', href: 'grupo' }
      ]" />
    </div>
    <div class="bg-black text-white flex flex-col items-center">
      <div v-for="(ejercicios, dia) in progresos" :key="dia" class="mb-8">
        <p class="text-2xl font-bold m-4 capitalize">{{ dia }}</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center">
          <div v-for="(progresosEjercicio, ejercicio) in ejercicios" :key="ejercicio"
            class="mb-6 p-4 bg-gray-100 rounded shadow flex flex-col items-center">
            <p class="font-semibold mb-2 text-black text-l">{{ ejercicio }}</p>
            <div class="w-full md:w-[350px] h-[230px] bg-white rounded flex items-center justify-center">
              <Line v-if="progresosEjercicio.length" :data="graficaData(progresosEjercicio)" :options="chartOptions" />
            </div>
          </div>
        </div>
      </div>


    </div>
    <PieDePagina />
  </div>
</template>
