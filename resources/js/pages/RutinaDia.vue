<script setup lang="ts">
import Cabecera from '@/components/Cabecera.vue';
import PieDePagina from '@/components/PieDePagina.vue';
import { reactive } from 'vue';
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

const props = defineProps<{
    ejerciciosHoy: Array<any>,
    entrenamientoCompletado: boolean
}>()

const progreso = reactive(
    props.ejerciciosHoy.map(ejercicio => ({
        nombre: ejercicio.nombre,
        series: Array.from({ length: ejercicio.series }).map(() => ({
            repeticiones: null,
            peso: null,
        }))
    }))
)
</script>
<template>
    <div class="h-screen w-full bg-black" v-if="entrenamientoCompletado">
        <a href="/" class="mt-10 ml-10 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 12 12">
                <path fill="#fff"
                    d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
            </svg>
        </a>
        <div class="justify-center items-center h-3/4 bg-black flex flex-col">
            <p class="text-white text-xl">¡Enhorabuena! Has completado el entrenamiento de hoy. Buen trabajo, ahora toca
                descansar.</p>
        </div>
    </div>
    <div class="" v-else>
        <div class="h-screen w-full bg-black " v-if="!props.ejerciciosHoy || ejerciciosHoy.length === 0">
            <a href="/" class="mt-10 ml-10 inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 12 12">
                    <path fill="#fff"
                        d="M10.5 6a.75.75 0 0 0-.75-.75H3.81l1.97-1.97a.75.75 0 0 0-1.06-1.06L1.47 5.47a.75.75 0 0 0 0 1.06l3.25 3.25a.75.75 0 0 0 1.06-1.06L3.81 6.75h5.94A.75.75 0 0 0 10.5 6" />
                </svg>
            </a>
            <div class="justify-center items-center h-3/4 bg-black flex flex-col">
                <p class="text-white text-xl">¡Hoy no hay entrenamiento programado! Aprovecha para descansar y recargar
                    energías!</p>
            </div>
        </div>
        <div class="" v-else>
            <div class="flex justify-center bg-black w-full h-20">
                <Cabecera top-0 fixed :enlaces="[
                    { titulo: 'CALENDARIO', href: 'calendario' },
                    { titulo: 'INICIO', href: 'home' },
                    { titulo: 'PROGRESO', href: 'progreso' },
                    { titulo: 'GRUPO', href: 'grupo' }
                ]" />
            </div>
            <section class="bg-black justify-center w-screen text-white flex pt-10 pb-10">
                <form action="/progress/store" method="post">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <div class="" v-for="(ejercicio, i) in ejerciciosHoy" :key="i">
                        <input type="hidden" :name="`progreso[${i}][nombre]`" :value="ejercicio.nombre" />
                        <p class="text-xl p-3">{{ ejercicio.nombre }}</p>
                        <p>Repeticiones estimadas {{ ejercicio.repeticiones }}</p>
                        <div class="flex mt-3" v-for="n in ejercicio.series">
                            <p>Serie numero {{ n }} :</p>
                            <input type="number" class="border rounded ml-2 mr-2"
                                :name="`progreso[${i}][series][${n - 1}][repeticiones]`" id="">
                            <p>repeticiones</p>
                            <input type="number" class=" border rounded ml-2 mr-2"
                                :name="`progreso[${i}][series][${n - 1}][peso]`" id="">
                            <p>kg</p>

                        </div>
                    </div>
                    <button type="submit"
                        class="bg-white text-black font-bold py-2 w-32 rounded hover:bg-gray-200 mt-3">
                        Enviar
                    </button>
                </form>
            </section>

            <PieDePagina />

        </div>
    </div>
</template>