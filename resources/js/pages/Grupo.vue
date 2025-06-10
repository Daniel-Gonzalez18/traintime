<script setup lang="ts">
import Cabecera from '@/components/Cabecera.vue';
import PieDePagina from '@/components/PieDePagina.vue';
const props = defineProps<{
  grupos: Array<any>,
}>();
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement)

// Opciones de la gráfica vacía
const emptyChartOptions = {
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

// Datos vacíos (solo estructura, sin puntos)
const emptyChartData = {
  labels: [], // fechas vacías
  datasets: [
    {
      label: "RM",
      data: [], // sin datos
      borderColor: "blue",
      backgroundColor: "rgba(30,144,255,0.2)",
      tension: 0.3
    }
  ]
}
</script>
<template>
  <div class="min-h-full flex flex-col">
    <div class="flex justify-center bg-black w-full h-20">
      <Cabecera :enlaces="[
        { titulo: 'CALENDARIO', href: 'calendario' },
        { titulo: 'RUTINA', href: 'rutina' },
        { titulo: 'PROGRESO', href: 'progreso' },
        { titulo: 'INICIO', href: 'home' }
      ]" />
    </div>
    <section class="bg-black w-full flex-1">
      <div class="p-5">
        <a class="text-[#43A047] absolute right-10 font-bold text-lg" href="/create/group">CREAR GRUPO +</a>
      </div>
      <div class=" bg-black w-full h-72 flex justify-center " v-if="grupos.length == 0">
        <p class="text-white font-bold text-xl">Todavia no perteneces a ningun grupo, puedes crearlo o que tus amigos te
          unan a
          sus
          grupos
        </p>
      </div>
      <div class="bg-black w-full flex flex-col" v-else>
        <p class="text-xl text-white mx-10">Lista de grupos :</p>
        <div class="bg-black min-h-screen px-6 py-10 flex flex-col items-center gap-10">
          <div v-for="grupo in grupos" :key="grupo.id" class="w-2/3 flex bg-black text-white border p-6 gap-8">
            <div class="flex flex-col justify-center gap-4 w-full">
              <h2 class="text-2xl font-bold uppercase pb-8">{{ grupo.name }}</h2>

              <a href="#" class="bg-white text-black font-bold p-3 rounded-full text-center hover:bg-gray-200">
                VER MÁS DETALLES
              </a>
              <a href="#" class="bg-white text-black font-bold p-3 rounded-full text-center hover:bg-gray-200">
                VER MÁS PROGRESOS
              </a>
              <a v-if="grupo.pivot?.role === 'admin'" href="#"
                class="bg-white text-black font-bold p-3 rounded-full text-center hover:bg-gray-200">
                GESTIONAR GRUPO
              </a>
            </div>

            <div class="w-full flex flex-col items-center">
              <h3 class="text-[#67FAFF] font-bold mb-2 text-xl">PROGRESO GENERAL</h3>
              <div class="w-full h-64 bg-white p-4 rounded">
                <Line :data="emptyChartData" :options="emptyChartOptions" />
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <PieDePagina />
  </div>
</template>
