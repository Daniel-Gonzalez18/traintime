<!-- <script setup lang="ts">
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
</template> -->





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
            repeticiones: '',
            peso: '',
        }))
    }))
)

const errores = reactive(
    props.ejerciciosHoy.map(ejercicio =>
        Array.from({ length: ejercicio.series }).map(() => ({
            repeticiones: '',
            peso: ''
        }))
    )
);

// Valida el formulario antes de enviar
function validarFormulario(e: Event) {
    let valido = true;

    props.ejerciciosHoy.forEach((ejercicio, i) => {
        for (let n = 0; n < ejercicio.series; n++) {
            errores[i][n].repeticiones = '';
            errores[i][n].peso = '';
            const rep = Number(progreso[i].series[n].repeticiones);
            const peso = Number(progreso[i].series[n].peso);

            // Repeticiones: 1-20 y obligatorio
            if (!rep || isNaN(rep) || rep < 1 || rep > 20) {
                errores[i][n].repeticiones = 'Entre 1 y 20 reps';
                valido = false;
            }
            // Peso: 0.1-300 y obligatorio
            if (!peso || isNaN(peso) || peso < 0.1 || peso > 300) {
                errores[i][n].peso = 'Entre 0.1 y 300 kg';
                valido = false;
            }
        }
    });

    if (!valido) e.preventDefault();
}
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
    <div v-else>
        <div class="h-screen w-full bg-black" v-if="!props.ejerciciosHoy || ejerciciosHoy.length === 0">
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
        <div v-else>
            <div class="flex justify-center bg-black w-full h-20">
                <Cabecera top-0 fixed :enlaces="[
                    { titulo: 'CALENDARIO', href: 'calendario' },
                    { titulo: 'INICIO', href: 'home' },
                    { titulo: 'PROGRESO', href: 'progreso' },
                    { titulo: 'GRUPO', href: 'grupo' }
                ]" />
            </div>
            <section class="bg-black justify-center w-screen text-white flex pt-10 pb-10">
                <form action="/progress/store" method="post" @submit="validarFormulario"
                    class="w-full max-w-2xl mx-auto">
                    <input type="hidden" name="_token" :value="csrfToken" />
                    <div v-for="(ejercicio, i) in ejerciciosHoy" :key="i">
                        <input type="hidden" :name="`progreso[${i}][nombre]`" :value="ejercicio.nombre" />
                        <p class="text-xl p-3">{{ ejercicio.nombre }}</p>
                        <p>Repeticiones estimadas {{ ejercicio.repeticiones }}</p>
                        <div class="flex mt-3 items-center gap-2" v-for="n in ejercicio.series" :key="n">
                            <p>Serie {{ n }}:</p>
                            <input type="number" class="border border-white rounded ml-2 mr-2 text-white bg-black px-2"
                                v-model="progreso[i].series[n - 1].repeticiones" min="1" max="20" placeholder="Reps"
                                :name="`progreso[${i}][series][${n - 1}][repeticiones]`" />
                            <span>reps</span>
                            <input type="number" class="border border-white rounded ml-2 mr-2 text-white bg-black px-2"
                                v-model="progreso[i].series[n - 1].peso" min="0.1" max="300" step="0.1"
                                placeholder="Peso (kg)" :name="`progreso[${i}][series][${n - 1}][peso]`" />
                            <span>kg</span>
                        </div>
                        <!-- Mostrar errores de cada serie -->
                        <div v-for="n in ejercicio.series" :key="'error-' + n" class="flex gap-4 mb-2">
                            <span v-if="errores[i][n - 1].repeticiones" class="text-red-400 text-xs">
                                Error serie {{ n }}: {{ errores[i][n - 1].repeticiones }}
                            </span>
                            <span v-if="errores[i][n - 1].peso" class="text-red-400 text-xs">
                                Error serie {{ n }}: {{ errores[i][n - 1].peso }}
                            </span>
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












<!-- <script setup lang="ts">
import Cabecera from '@/components/Cabecera.vue';
import PieDePagina from '@/components/PieDePagina.vue';
import { reactive, ref } from 'vue';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

const props = defineProps<{
    ejerciciosHoy: Array<any>,
    entrenamientoCompletado: boolean
}>()

// Estado reactivo para el progreso
const progreso = reactive(
    props.ejerciciosHoy.map(ejercicio => ({
        nombre: ejercicio.nombre,
        series: Array.from({ length: ejercicio.series }).map(() => ({
            repeticiones: null,
            peso: null,
        }))
    }))
)

// Estado para errores
const errores = reactive(
    props.ejerciciosHoy.map(ejercicio =>
        Array.from({ length: ejercicio.series }).map(() => ({
            repeticiones: '',
            peso: ''
        }))
    )
);

const envioError = ref('');

// Validación de campos
function validarFormulario() {
    let valido = true;
    envioError.value = '';
    props.ejerciciosHoy.forEach((ejercicio, i) => {
        for (let n = 0; n < ejercicio.series; n++) {
            errores[i][n].repeticiones = '';
            errores[i][n].peso = '';
            const rep = progreso[i].series[n].repeticiones;
            const peso = progreso[i].series[n].peso;
            // Repeticiones: 1-20
            if (!rep || rep < 1 || rep > 20) {
                errores[i][n].repeticiones = '1-20 reps';
                valido = false;
            }
            // Peso: 0.1-300
            if (!peso || peso < 0.1 || peso > 300) {
                errores[i][n].peso = '0.1 - 300 kg';
                valido = false;
            }
        }
    });
    return valido;
}

async function enviarProgreso(e: Event) {
    e.preventDefault();
    if (!validarFormulario()) return;

    // Montar el payload tal como lo necesitas
    const payload = {
        progreso: progreso
    };
    try {
        const res = await fetch('/progress/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
            },
            body: JSON.stringify(payload)
        });
        if (!res.ok) throw new Error('Fallo al guardar progreso');
        location.reload();
    } catch (err: any) {
        envioError.value = err.message || 'Error al enviar datos';
    }
}
</script>

<template>
    <div class="h-screen w-full bg-black" v-if="entrenamientoCompletado">
       
<!-- </div>
<div v-else>
        <div class="h-screen w-full bg-black" v-if="!props.ejerciciosHoy || ejerciciosHoy.length === 0">
         
        </div>
<div v-else>
            <div class="flex justify-center bg-black w-full h-20">
                <Cabecera top-0 fixed :enlaces="[
                    { titulo: 'CALENDARIO', href: 'calendario' },
                    { titulo: 'INICIO', href: 'home' },
                    { titulo: 'PROGRESO', href: 'progreso' },
                    { titulo: 'GRUPO', href: 'grupo' }
                ]" />
            </div>
<section class="bg-black justify-center w-screen text-white flex pt-10 pb-10">
                <form @submit="enviarProgreso" class="w-full max-w-2xl mx-auto">
                    <div v-if="envioError" class="text-red-400 font-bold mb-4">{{ envioError }}</div>
                    <div v-for="(ejercicio, i) in ejerciciosHoy" :key="i">
                        <p class="text-xl p-3">{{ ejercicio.nombre }}</p>
                        <p>Repeticiones estimadas {{ ejercicio.repeticiones }}</p>
                        <div class="flex mt-3 items-center gap-2" v-for="n in ejercicio.series" :key="n">
                            <p>Serie {{ n }}:</p>
                            <input type="number" class="border rounded ml-2 mr-2 text-white px-2"
                                v-model.number="progreso[i].series[n - 1].repeticiones" min="1" max="20"
                                placeholder="" />
                            <span>repeticiones</span>
                            <input type="number" class="border rounded ml-2 mr-2 text-white px-2"
                                v-model.number="progreso[i].series[n - 1].peso" min="0.1" max="300" step="0.1"
                                placeholder="" />
                            <span>kg</span>
                            <span class="text-red-500 text-xs ml-1" v-if="errores[i][n - 1].repeticiones">
                                {{ errores[i][n - 1].repeticiones }}
                            </span>
                            <span class="text-red-500 text-xs ml-1" v-if="errores[i][n - 1].peso">
                                {{ errores[i][n - 1].peso }}
                            </span>
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
</template> --> -->
