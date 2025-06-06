<script setup lang="ts">
import Cabecera from "@/components/Cabecera.vue";
import PieDePagina from "@/components/PieDePagina.vue";
import { computed } from "vue";
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
import { Line } from "vue-chartjs";

const props = defineProps<{ progresos: Record<string, any[]> }>();

// Agrupar progresos por día y luego por ejercicio
const progresosPorDia = computed(() => {
  const res: Record<string, Record<string, any[]>> = {};
  Object.entries(props.progresos).forEach(([ejercicio, lista]) => {
    lista.forEach((p) => {
      if (!res[p.day]) res[p.day] = {};
      if (!res[p.day][ejercicio]) res[p.day][ejercicio] = [];
      res[p.day][ejercicio].push(p);
    });
  });

  // Opcional: Ordenar días de la semana
  const diasOrdenados = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
  const resultadoOrdenado: Record<string, Record<string, any[]>> = {};
  diasOrdenados.forEach((dia) => {
    if (res[dia]) resultadoOrdenado[dia] = res[dia];
  });
  // Añade otros días fuera de orden (por si acaso)
  Object.keys(res).forEach((dia) => {
    if (!diasOrdenados.includes(dia)) resultadoOrdenado[dia] = res[dia];
  });

  return resultadoOrdenado;
});

// Devuelve los datos para cada gráfica
function getGraficaData(progresos: any[]) {
  return {
    labels: progresos.map((p) => p.fecha),
    datasets: [
      {
        label: "RM",
        data: progresos.map((p) => p.rm),
        borderColor: "blue",
        backgroundColor: "rgba(0, 0, 255, 0.2)",
        tension: 0.4,
        fill: true,
      },
    ],
  };
}

const options = {
  responsive: true,
  plugins: {
    legend: { display: true },
    title: { display: false }
  },
  scales: {
    y: { beginAtZero: true }
  }
};
</script>

<template>
  <div class="flex justify-center bg-black w-full h-20">
    <Cabecera :enlaces="[
      { titulo: 'CALENDARIO', href: 'calendario' },
      { titulo: 'RUTINA', href: 'rutina' },
      { titulo: 'INICIO', href: 'home' },
      { titulo: 'GRUPO', href: 'grupo' }
    ]" />
  </div>


  <div class="p-6">
    <div v-for="(ejercicios, dia) in progresosPorDia" :key="dia" class="mb-10 max-w-md mx-auto">
      <h2 class="text-2xl font-bold mb-4 capitalize">{{ dia }}</h2>
      <div v-for="(progresos, ejercicio) in ejercicios" :key="ejercicio" class="mb-8">
        <h3 class="text-xl font-semibold mb-2 ">{{ ejercicio }}</h3>
        <Line :data="getGraficaData(progresos)" :options="options" />
      </div>
    </div>
  </div>
  <PieDePagina />
</template>
